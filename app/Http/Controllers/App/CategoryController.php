<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

class CategoryController
{
    public function index()
    {
        return view('app.pages.categories.index');
    }

    public function edit($id)
    {
        return view('app.pages.categories.edit');
    }
}
