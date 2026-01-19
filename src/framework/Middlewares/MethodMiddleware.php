<?php

namespace G1c\Culturia\framework\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MethodMiddleware
{
    public function __invoke(ServerRequestInterface $request, $next): ResponseInterface
    {
        if(array_key_exists("_METHOD", $request->getParsedBody()) && in_array($request->getParsedBody()["_METHOD"], ["DELETE", "PUT"]))
        {
            $request["REQUEST_METHOD"] = $request->getParsedBody()["_METHOD"];
        }
        return $next($request);
    }

}