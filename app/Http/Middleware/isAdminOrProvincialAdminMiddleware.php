<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\ProvincialAdmin;
use Closure;
use Illuminate\Http\Request;

class isAdminOrProvincialAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \never
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user()->cast();
        if ((get_class($user) !== Admin::class || get_class($user) !== ProvincialAdmin::class) === 1) {
            return abort(403);
        }
        return $next($request);
    }
}
