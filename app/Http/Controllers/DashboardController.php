<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {

        // dd(auth()->user()->role);
        if (auth()->user()->role == 1) {
            // return Inertia::render("Admin/Admin");
            return view("dashboard", ["auth" => auth()->user()]);
        } elseif (auth()->user()->role == 2) {
            // return Inertia::render("Editor/Editor");
            return view("dashboard", ["auth" => auth()->user()]);
        } elseif (auth()->user()->role == 3) {
            // return Inertia::render("Creator/Creator");
            return view("dashboard", ["auth" => auth()->user()]);
        } elseif (auth()->user()->role == 5) {
            // return Inertia::render("User/Dashboard");
            return view("dashboard", ["auth" => auth()->user()]);
        } else {
            redirect('/');
        }
    }
}
