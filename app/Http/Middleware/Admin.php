<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
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
        $ldms_role_id = Auth::user()->isAdmin();
        $ldms_role_data = Role::where('id', $ldms_role_id)->first();

        if (Auth::check() && $ldms_role_data->title == 'admin') {
            return $next($request);
        }
        return back();
    }
}
