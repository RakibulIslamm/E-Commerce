<?php

namespace App\Http\Controllers\App;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ShippingSetting;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenant = tenant();

        $registration_process = $tenant->registration_process;
        $cart_breadcrumbs = Breadcrumbs::generate('cart');
        $shippingSetting = ShippingSetting::with('rules')
            ->orderBy('minimum_order', 'asc')
            ->get()->first();

        if (!Auth::check() && $registration_process == 'Mandatory with confirmation') {
            return redirect()->route('app.login');
        } elseif (!Auth::check() && $registration_process == 'Mandatory') {
            return redirect()->route('app.login');
        } else {
            if (Auth::check()) {
                $cart_items = Cart::with('product')->where('user_id', Auth::id())->get();
                return view('app.pages.cart.index', ['cart_items' => $cart_items, 'breadcrumbs' => $cart_breadcrumbs, "shipping_setting"=>$shippingSetting]);
            } else {
                // return redirect()->route('app.login');
                return view('app.pages.cart.index', ['cart_items' => [], 'breadcrumbs' => $cart_breadcrumbs, "shipping_setting"=>$shippingSetting]);
            }
        }
    }

    public function get_cart(Request $request)
    {
        try {
            $cart = session()->get('cart', []);
            return response()->json(['success' => true, 'cart_items' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, '' => $e->getMessage()]);
        }
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Add to cart
        try {
            $product = Product::findOrFail($request->product_id);
            if (Auth::check()) {
                if ($product->GIACENZA < $request->quantity) {
                    return response()->json(['success' => false, "message" => 'Items current not available in the requested quantity']);
                }

                $cart = Cart::updateOrCreate(
                    [
                        'product_id' => $request->product_id,
                        'user_id' => Auth::id(),
                    ],
                    [
                        'quantity' => $request->quantity,
                    ]
                );

                // $cart->quantity += 1;
                $cart->save();

                $cart->load('product');

                return response()->json(['success' => true, 'cart_item' => $cart]);
            } else {
                if ($product->GIACENZA < $request->quantity) {
                    return response()->json(['success' => false, "message" => 'Items current not available in the requested quantity']);
                }
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

    }


    public function storeNew(Request $request)
    {
        $isB2B = tenant()?->business_type === 'B2B' || tenant()?->business_type === 'B2B Plus';

        $user = auth()->user();

        try {
            $product = Product::findOrFail($request->product_id);
            $pxc = $product->PXC;
            $unitamisura = $product->UNITAMISURA;

            $requestedQuantity = (int) $request->quantity;

            // Check B2B minimum quantity rule
            if ($isB2B && $requestedQuantity < $pxc) {
                return response()->json([
                    'success' => false,
                    'message' => "La quantità minima ordinabile per questo prodotto è {$pxc} {$unitamisura}."
                ]);
            }
            else if ($isB2B && ($requestedQuantity % $pxc) != 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Quantità non valida."
                ]);
            }

            // Check stock availability
            if ($product->GIACENZA < $requestedQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Articoli attualmente non disponibili nella quantità richiesta'
                ]);
            }

            // Decode FOTO
            if (isset($product->FOTO) && is_string($product->FOTO)) {
                $decodedFoto = json_decode($product->FOTO, true);
                $product->FOTO = is_array($decodedFoto) && !empty($decodedFoto) ? $decodedFoto[0] : '';
            } else {
                $product->FOTO = '';
            }

            $cart = session()->get('cart', []);

            // Update quantity if already in cart
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] = $requestedQuantity;

                // Update stock info for all items
                foreach ($cart as $cartItem) {
                    $prod = Product::find($cartItem['product_id']);
                    if ($prod) {
                        $cart[$prod->id]['stock'] = $prod->GIACENZA;
                    }
                }

                session()->put('cart', $cart);
                return response()->json(['success' => true, 'cart_items' => $cart]);
            }

            // Determine price (promo or regular)
            $PREPROMOIMP = isset($product['PREPROMOIMP']) && (float)$product['PREPROMOIMP'] > 0
                ? (float)number_format((float)$product['PREPROMOIMP'], 2)
                : false;

            // Add new product to cart

            $price = match (true) {
                $user && $user->price_list == 3 => $product->PRE3IMP,
                $user && $user->price_list == 2 => $product->PRE2IMP,
                $user && $user->price_list == 1 => $product->PRE1IMP,
                default => $product->PRE1IMP,
            };

            $price_with_vat = match (true) {
                $user && $user->price_list == 3 => $product->PRE3IVA,
                $user && $user->price_list == 2 => $product->PRE2IVA,
                $user && $user->price_list == 1 => $product->PRE1IVA,
                default => $product->PRE1IVA,
            };


            $cart[$product->id] = [
                "product_id" => $product->id,
                "id_articolo" => $product?->IDARTICOLO,
                "name" => $product?->DESCRIZIONEBREVE,
                "quantity" => $requestedQuantity,
                "price" => $price,
                "price_with_vat" => $price_with_vat,
                "photo" => $product?->FOTO,
                'stock' => $product?->GIACENZA,
                'vat' => $product?->ALIQUOTAIVA,
                'selected' => true,
                'pxc' => $product?->PXC
            ];

            session()->put('cart', $cart);
            return response()->json(['success' => true, 'cart_items' => $cart]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }


    /* 
    $cart[$product->id]->stock = [
        'product_id' => $product->id,
        'name' => $product->DESCRIZIONEBREVE,
        'quantity' => $cartItem['quantity'],
        'price' => $product->PRE1IMP,
        'stock' => $product->GIACENZA,
        'vat' => $product->ALIQUOTAIVA,
        'photo' => isset($product->FOTO) ? json_decode($product->FOTO)[0] : '',
    ];
    
    */

    public function setCartToTable(Request $request)
    {
        $cartItems = json_decode($request->cart, true);
        foreach ($cartItems as $item) {
            $cart = Cart::firstOrNew(['product_id' => $item['product_id'], 'user_id' => Auth::id()]);
            $cart->quantity += $item['quantity'];
            $cart->save();
        }
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart)) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, "message" => 'Product not found in cart']);
    }
}
