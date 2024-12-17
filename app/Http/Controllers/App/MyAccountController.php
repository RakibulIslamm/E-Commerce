<?php

namespace App\Http\Controllers\App;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $my_orders = Order::where('user_id', Auth::user()->id)->with('order_items.product')->get();

        // foreach ($my_orders as $order) {
        //     foreach ($order->order_items as $item) {
        //         // dd(gettype($item->product->FOTO) == 'string');
        //         // $item->product->FOTO = json_decode($item->product->FOTO);
        //     }
        // }
        // dd($my_orders);
        return view('app.pages.my-account.orders', ['orders' => $my_orders]);
    }

    public function change_password()
    {
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        return view('app.pages.my-account.change-password');
    }

    public function account()
    {
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        return view('app.pages.my-account.account');
    }

    public function update_account_info(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('app.login');
        }
        $validate = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'date_of_birth' => ['sometimes', 'date'],
            'address' => ['sometimes', 'string', 'max:255'],
            'postal_code' => ['sometimes', 'string', 'max:10'],
            'city' => ['sometimes', 'string', 'max:255'],
            'province' => ['sometimes', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:255'],
            'business_name' => ['sometimes', 'string', 'max:255'],
            'telephone' => 'required|string',
            'vat_number' => ['sometimes', 'string', 'max:255'],
            'pec_address' => ['nullable', 'string', 'max:255'],
            'sdi_code' => ['sometimes', 'string', 'max:255'],
        ]);
        // dd($validate);
        $user = request()->user();
        $user->update($validate);
        return redirect()->back()->with('success', "Updated successfully");

    }

}
