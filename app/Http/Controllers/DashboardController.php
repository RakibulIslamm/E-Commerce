<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 1) {
            return Inertia::render("Admin/Admin");
        } elseif (auth()->user()->role == 2) {
            return Inertia::render("Editor/Editor");
        } elseif (auth()->user()->role == 3) {
            return Inertia::render("Creator/Creator");
        } elseif (auth()->user()->role == 5) {
            return Inertia::render("User/Dashboard");
        } else {
            redirect('/');
        }
    }
}
