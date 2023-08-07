<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
