<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class RegistrationProcess
{
    public function handle($request, Closure $next)
    {   
        $tenant = tenant();
        if (!Auth::check()) {
            
        }
        elseif(Auth::check()){
            if($tenant->business_type == 'B2B Plus'){
                if(!Auth::user()->email_verified_at){
                    // return redirect('/verify-email');
                }
            }
            elseif($tenant->registration_process == 'Mandatory with confirmation'){
                if(!Auth::user()->email_verified_at){
                    // return redirect('/verify-email');
                }
            }
        }
        return $next($request);
    }
}
