<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Router\RouterException;

class RouterMiddleware
{
    private Router $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }

    public function __invoke($request, callable $next)
    {
        try {
            print $this->router->match($request["REQUEST_URI"]);
        } catch (RouterException){
            return $next($request);
        }
    }

}