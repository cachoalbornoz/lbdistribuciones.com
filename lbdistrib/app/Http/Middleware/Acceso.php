<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;


class Acceso
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
        if(Auth::user()->admin()){
            
            return $next($request);    

        }else{

            abort(401);

        }

        
    }
}
