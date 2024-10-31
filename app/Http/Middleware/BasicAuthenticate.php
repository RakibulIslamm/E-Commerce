<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // Get the Authorization header
        $authHeader = $request->headers->get('Authorization');

        $user = '';
        $pass = '';

        if (strpos($authHeader, 'Basic ') === 0) {
            $encodedCredentials = substr($authHeader, 6);
            $decodedCredentials = base64_decode($encodedCredentials);
            [$username, $password] = explode(':', $decodedCredentials);
            $user = $username;
            $pass = $password;

            $rest_username = tenant()->rest_api_user;
            $rest_password = tenant()->rest_api_password; 

            // $apiCredential && password_verify($password, $apiCredential->password)

            if (($rest_username == $username && $rest_password == $password) || (Auth::check() && Auth::user()->role === 1)) {
                return $next($request);
            }
        }

        return response()->json([
            'codice' => 'KO',
            'errore' => [
                'numero' => 100,
                'msg' => 'Utente o password errati',
                'extra_msg' => "user $user, pass $pass"
            ]
        ], 401);
    }
}
