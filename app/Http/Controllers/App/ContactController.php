<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

class ContactController
{
    public function index(Request $request)
    {
        return view("app.pages.contact");
    }
}
