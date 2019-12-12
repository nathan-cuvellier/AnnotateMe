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
        if (!session()->has('expert') && !in_array($request->url(), $this->whiteList())) {
            return redirect(route('auth.login'))->with('message', 'You\'re not connected');
        }

        return $next($request);
    }

    /**
     * Authorize different URL to access without are connected
     */
    public function whiteList(){
        return [
            route('auth.login'), // need to put in session 'typeExp'
            route('home') // avoid message "You're not connected" when you want access to the web site => home redirect in login page OR list projects
        ];
    }
}
