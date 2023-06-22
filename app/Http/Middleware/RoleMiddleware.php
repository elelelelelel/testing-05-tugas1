<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class RoleMiddleware
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
        if(Auth::guest()){
            return redirect('login');
        }
        $roles = array_slice(func_get_args(), 2);
        $user_roles = Auth::user()->roles->pluck('name')->toArray();
        foreach($roles as $role){
            if(in_array($role,$user_roles)){
                return $next($request);
            }
        }

        return abort(403);
    }
}
