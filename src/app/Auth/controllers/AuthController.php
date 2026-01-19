<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\framework\Renderer;
use Psr\Http\Message\ServerRequestInterface;

class AuthController
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {

        $this->renderer = $renderer;
    }
    public function cgu(ServerRequestInterface $request): string
    {
        return $this->renderer->render("@auth/cgu");
    }
}