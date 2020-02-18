<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if ( Auth::check()){

            if (Auth::user()->isAdmin()){ 
                return $next($request); 
            } 
            elseif(Auth::user()->isUser()){
                return redirect()->route('user.home');
            }
        }
        
        Auth::logout();
        return redirect('login');
    }
}
