<?php

namespace G1c\Culturia\framework\Middlewares;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{
    public function __invoke(ServerRequestInterface $request, $next): ResponseInterface
    {
        return new Response(404, [], "Page not Found");
    }

}