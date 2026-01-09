<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\framework\Renderer;

class ProfileController
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {

        $this->renderer = $renderer;
    }

    public function __invoke()
    {
        return $this->renderer->render("@auth/profile/index");
    }
}