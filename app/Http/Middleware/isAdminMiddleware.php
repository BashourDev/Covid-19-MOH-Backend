<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (get_class(auth()->user()->cast() !== Admin::class)) {
            return abort(403);
        }
        return $next($request);
    }
}
