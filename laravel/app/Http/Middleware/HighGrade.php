<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class HighGrade
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos(session('expert')['type'], 'admin') === false) {
            return abort(403);
        }

        return $next($request);
    }
}
