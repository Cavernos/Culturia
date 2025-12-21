<?php

namespace G1c\Culturia\framework\Middlewares;

use G1c\Culturia\framework\Renderer;

class NotFoundMiddleware
{
    public function __invoke($request, $next): void
    {
        header("LOCATION: /", 404);
    }

}