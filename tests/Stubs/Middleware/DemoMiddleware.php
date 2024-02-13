<?php

namespace Wnx\LaravelStats\Tests\Stubs\Middleware;

use Closure;

class DemoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
