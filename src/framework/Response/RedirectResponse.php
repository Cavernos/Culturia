<?php

namespace G1c\Culturia\framework\Response;

use GuzzleHttp\Psr7\Response;

class RedirectResponse extends Response
{

    public function __construct(string $path)
    {
        parent::__construct(301, ['Location' => $path]);
    }

}