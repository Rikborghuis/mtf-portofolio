<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('baseauth.user')->contains([$request->getUser(), $request->getPassword()])) {
            return $next($request);
        }
        return response('foute login', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
