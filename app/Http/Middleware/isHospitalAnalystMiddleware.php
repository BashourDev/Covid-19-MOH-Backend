<?php

namespace App\Http\Middleware;

use App\Models\HospitalAnalyst;
use Closure;
use Illuminate\Http\Request;

class isHospitalAnalystMiddleware
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
        if (get_class(auth()->user()->cast() !== HospitalAnalyst::class)) {
            return abort(403);
        }
        return $next($request);
    }
}
