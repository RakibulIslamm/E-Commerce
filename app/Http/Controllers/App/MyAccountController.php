<?php

namespace App\Http\Controllers\App;

use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class MyAccountController
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        return view('app.pages.my-account.index');
    }

    public function my_orders()
    {
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        $my_orders = Order::where('user_id', Auth::user()->id)->with('order_items')->get();
        return view('app.pages.my-account.orders', ['orders' => $my_orders]);
    }

    public function change_password()
    {
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        return view('app.pages.my-account.change-password');
    }

    public function billing()
    {
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        return view('app.pages.my-account.billing');
    }

}
