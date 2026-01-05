<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Router\RouterException;

class RouterMiddleware
{
    private Router $router;
    private Logger $logger;

    public function __construct(Logger $logger, Router $router)
    {

        $this->router = $router;
        $this->logger = $logger;
    }

    public function __invoke($request, callable $next)
    {
        try {
            $this->logger->info("Route ". $request['REQUEST_URI'] . " matched");
            print $this->router->match($request);
        } catch (RouterException){
            $this->logger->info("No route for". $request['REQUEST_URI']);
            return $next($request);
        }
    }

}