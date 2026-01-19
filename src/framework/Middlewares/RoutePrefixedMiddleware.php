<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        if(str_starts_with($path, $this->routePrefix)) {
            return $this->container->get($this->middleware)($request, $next);
        }
        return $next($request);
    }
}