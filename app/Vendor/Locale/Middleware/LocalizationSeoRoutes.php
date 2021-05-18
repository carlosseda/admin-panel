<?php

namespace App\Vendor\Locale\Middleware;

use App\Vendor\Locale\Middleware\LocalizationSeoMiddlewareBase;
use Closure;

class LocalizationSeoRoutes extends LocalizationSeoMiddlewareBase
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
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $app = app();

        $routeName = $app['localizationseo']->getRouteNameFromAPath($request->getUri());

        $app['localizationseo']->setRouteName($routeName);

        return $next($request);
    }
}

