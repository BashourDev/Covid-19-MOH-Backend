<?php

namespace App\Http\Middleware;

use App\Models\PatientAnalyst;
use Closure;
use Illuminate\Http\Request;

class isPatientAnalystMiddleware
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
        if (get_class(auth()->user()->cast()) !== PatientAnalyst::class) {
            return abort(403);
        }
        return $next($request);
    }
}
