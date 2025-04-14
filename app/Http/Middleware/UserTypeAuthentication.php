<?php

namespace App\Http\Middleware;

use Closure;

class UserTypeAuthentication
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
        $userGroup = auth()->user()->user_group;
        if($userGroup != 1){
            return redirect('/access-denied');
        }
        return $next($request);
    }
}
