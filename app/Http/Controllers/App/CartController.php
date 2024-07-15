<?php

namespace App\Http\Controllers\App;

use App\Models\Cart;
use App\Models\Product;
use Auth;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

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

        if (!Auth::check() && $registration_process == 'Mandatory with confirmation') {
            return redirect()->route('app.login');
        } elseif (!Auth::check() && $registration_process == 'Mandatory') {
            return redirect()->route('app.login');
        } else {
            if (Auth::check()) {
                $cart_items = Cart::with('product')->where('user_id', Auth::id())->get();
                return view('app.pages.cart.index', ['cart_items' => $cart_items, 'breadcrumbs' => $cart_breadcrumbs]);
            } else {
                // return redirect()->route('app.login');
                return view('app.pages.cart.index', ['cart_items' => [], 'breadcrumbs' => $cart_breadcrumbs]);
            }
        }
    }

    public function get_cart(Request $request)
    {
        try {
            if (Auth::check()) {
                $cart_items = Cart::with('product')->where('user_id', Auth::id())->get();
            } else {
                $cart_items = collect(json_decode($request->cart, true))->map(function ($item) {
                    $product = Product::find($item['product_id']);

                    if ($product) {
                        $foto = json_decode($product->FOTO, true);

                        if (is_array($foto)) {
                            $product->FOTO = $foto[0];
                        }

                        return (object) [
                            'product' => $product,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                        ];
                    }
                });
            }
            return response()->json(['success' => true, 'cart_items' => $cart_items]);
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
        if (Auth::check()) {
            Cart::where('product_id', $id)
                ->where('user_id', Auth::id())
                ->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
