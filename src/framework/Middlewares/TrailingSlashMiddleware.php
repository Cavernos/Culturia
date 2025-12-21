<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Router\Router;

class TrailingSlashMiddleware
{
    public function __invoke($request, callable $next)
    {
        $uri = $request["REQUEST_URI"];
        if(!empty($uri) && $uri[-1] === "/" && $uri != "/"){
            header("LOCATION: ". substr($uri, 0, -1), 301);
        }
        return $next($request);
    }
}