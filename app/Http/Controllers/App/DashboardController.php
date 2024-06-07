<?php

namespace App\Http\Controllers\App;

use Diglactic\Breadcrumbs\Breadcrumbs;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboard = Breadcrumbs::generate('dashboard');
        // dd($dashboard);
        return view("app.dashboard", ["auth" => auth()->user()]);
    }
}
