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

        // session()->forget('cart');
        // return response()->json(['request' => $request->all()]);
        try {
            $product = Product::findOrFail($request->product_id);
            $cart = session()->get('cart', []);
            if ($product->GIACENZA < $request->quantity) {
                return response()->json(['success' => false, "message" => 'Items current not available in the requested quantity']);
            }
            
            if (isset($product->FOTO) && is_string($product->FOTO)) {
                $decodedFoto = json_decode($product->FOTO, true); // Decoding as associative array
                $product->FOTO = is_array($decodedFoto) && !empty($decodedFoto) ? $decodedFoto[0] : '';
            } else {
                $product->FOTO = '';
            }

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] = $request->quantity;
                foreach ($cart as $cartItem) {
                    $product = Product::find($cartItem['product_id']);
                    if ($product) {
                        $cart[$product->id]['stock'] = $product->GIACENZA;
                    }
                }
                session()->put('cart', $cart);
                return response()->json(['success' => true, 'cart_items' => $cart]);
            }

            $cart[$product->id] = [
                "product_id" => $product->id,
                "name" => $product->DESCRIZIONEBREVE,
                "quantity" => 1,
                "price" => $product->PREPROMOIMP ? $product->PREPROMOIMP : $product->PRE1IMP,
                "photo" => $product->FOTO,
                'stock' => $product->GIACENZA,
                'vat' => $product->ALIQUOTAIVA,
                'selected' => true
            ];

            session()->put('cart', $cart);
            return response()->json(['success' => true, 'cart_items' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
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
