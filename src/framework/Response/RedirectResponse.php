<?php

namespace G1c\Culturia\framework\Response;

class RedirectResponse
{

    public function __construct(string $path)
    {
        header("Location : $path",true, 301);
        exit;
    }

}