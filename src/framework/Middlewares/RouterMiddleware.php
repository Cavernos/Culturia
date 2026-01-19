<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Router\RouterException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouterMiddleware
{
    private Router $router;
    private Logger $logger;

    public function __construct(Logger $logger, Router $router)
    {

        $this->router = $router;
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        try {
            $this->logger->info("Route ".  $request->getUri()->getPath() . " matched");
            return $this->router->match($request);
        } catch (RouterException){
            $this->logger->info("No route for". $request->getUri()->getPath());
            return $next($request);
        }
    }

}