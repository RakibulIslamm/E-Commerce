<?php

namespace App\Http\Controllers\App;

use App\Models\Tenant;
use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        return view("app.index");
    }
}
