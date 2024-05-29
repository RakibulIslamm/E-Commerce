<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCentralDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedDomains = config('tenancy.central_domains', []);
        $requestDomain = $request->getHost();

        if (!in_array($requestDomain, $allowedDomains)) {
            abort(404);
        }

        return $next($request);
    }
}
