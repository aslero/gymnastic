<?php

namespace App\Http\Middleware;

use Closure;

class CheckConfirmedEmail
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
        if (!$request->user()->confirmed()){
            return redirect()->route('home', $request->user());
        }

        return $next($request);
    }
}
