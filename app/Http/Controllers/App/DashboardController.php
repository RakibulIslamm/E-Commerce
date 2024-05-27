<?php

namespace App\Http\Controllers\App;

class DashboardController extends Controller
{
    public function index()
    {
        return view("app.dashboard", ["auth" => auth()->user()]);
    }
}
