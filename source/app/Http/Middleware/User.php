<?php

namespace App\Http\Middleware;

use Closure; 
use Auth;
class User
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
                
                return redirect()->route('admin.home');
            }
            elseif (Auth::user()->isUser()){
                
                return $next($request); 
            } 
        }
        
        Auth::logout();
        return redirect('login');
    }
}
