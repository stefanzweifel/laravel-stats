<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Stubs\Middlewares;

use Closure;

class RouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
