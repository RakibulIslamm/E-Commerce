<?php

namespace App\Http\Controllers\CentralApp;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->role);
        if (auth()->user()) {
            return view("central_app.dashboard");
        } else {
            redirect('/register');
        }
    }
}
