<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Editor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('central.login');
        }
        return $next($request);
        /* $userRole = Auth::user()->role;

        if($userRole == 1){
            return redirect()->route('admin.dashboard');
        }
        elseif($userRole == 2){
            return $next($request);
        }
        elseif($userRole == 3){
            return redirect()->route('creator.dashboard');
        }
        elseif($userRole == 5){
            return redirect()->route('dashboard');
        }
        else{
            Auth::logout();
            return redirect()->route('login');
        } */
    }
}
