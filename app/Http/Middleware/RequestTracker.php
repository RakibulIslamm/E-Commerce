<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RequestTracker
{
    public function handle($request, Closure $next)
    {
        // Log request details
        Log::info('Request Logged:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_id' => $request->user() ? $request->user()->id : null,
            'timestamp' => now(),
        ]);
        
        // Check if user is authenticated and inactive
        $user = auth()->user();
        if (isset($user) && !$user->active) {
            // return redirect()->route('app.lock');
        }

        return $next($request);
    }
}
