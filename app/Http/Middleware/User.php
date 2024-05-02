<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $next($request);
        /* $userRole = Auth::user()->role;
        if($userRole == 1){
            return redirect()->route('admin.dashboard');
        }
        elseif($userRole == 2){
            return redirect()->route('editor.dashboard');
        }
        elseif($userRole == 3){
            return redirect()->route('creator.dashboard');
        }
        elseif($userRole == 5){
            return $next($request);
        }
        else{
            Auth::logout();
            return redirect()->route('login');
        } */
    }
}
