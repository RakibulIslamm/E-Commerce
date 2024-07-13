<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransferCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->session()->has('cart')) {
            dd($request->session()->get('cart', '[]'));
            // $cartItems = json_decode($request->session()->get('cart'), true);
            // foreach ($cartItems as $item) {
            //     $cart = Cart::firstOrNew(['product_id' => $item['product_id'], 'user_id' => Auth::id()]);
            //     $cart->quantity += $item['quantity'];
            //     $cart->save();
            // }
            // $request->session()->forget('cart');
        }

        return $next($request);
    }
}
