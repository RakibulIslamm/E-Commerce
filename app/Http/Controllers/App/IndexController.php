<?php

namespace App\Http\Controllers\App;

use App\Models\ContentSlider;
use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        $sliders = ContentSlider::orderBy('position')->get();
        return view("app.pages.index", ['sliders' => $sliders]);
    }
}
