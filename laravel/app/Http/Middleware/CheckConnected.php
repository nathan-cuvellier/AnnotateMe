<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckConnected
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->get('typeExp') == null && !in_array($request->url(), $this->whiteList())) {
            return redirect(route('auth'))->with('message', 'You\'re not connected');
        }

        return $next($request);
    }

    /**
     * Authorize different URL to access without are connected
     */
    public function whiteList(){
        return [
            route('auth'),
            route('account_check'), // need to put in session 'typeExp'
        ];
    }
}
