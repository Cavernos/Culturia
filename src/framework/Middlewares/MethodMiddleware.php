<?php

namespace G1c\Culturia\framework\Middlewares;

class MethodMiddleware
{
    public function __invoke($request, $next)
    {
        if(array_key_exists("_METHOD", $_POST) && in_array($_POST["_METHOD"], ["DELETE", "PUT"]))
        {
            $request["REQUEST_METHOD"] = $_POST["_METHOD"];
        }
        return $next($request);
    }

}