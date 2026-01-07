<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Container;

class RoutePrefixedMiddleware
{
    private string $routePrefix;
    private string $middleware;
    private Container $container;

    public function __construct(Container $container, string $routePrefix, string $middleware)
    {

        $this->routePrefix = $routePrefix;
        $this->middleware = $middleware;
        $this->container = $container;
    }

    public function __invoke($request, callable $next)
    {
        $path = parse_url($request["REQUEST_URI"], PHP_URL_PATH);
        if(str_starts_with($path, $this->routePrefix)) {
            $request["prefix"] = $this->routePrefix;
            return $this->container->get($this->middleware)($request, $next);
        }
        return $next($request);
    }
}