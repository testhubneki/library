<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->hasHeader('X-Api-Key') ||  $request->header('X-Api-Key') != config('api.api_key')) {
            return response(['error' =>'auth. forbidden'], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
