<?php

namespace App\Http\Controllers\App\Dashboard;

use Diglactic\Breadcrumbs\Breadcrumbs;

class DashboardController
{
    public function index()
    {
        $dashboard = Breadcrumbs::generate('dashboard');
        // dd($dashboard);
        return view("app.pages.dashboard.index");
    }
}
