<?php

namespace G1c\Culturia\app\Home\controllers;

use G1c\Culturia\framework\Renderer;

class HomeController
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {

        $this->renderer = $renderer;
    }

    public function __invoke()
    {
        return $this->index();
    }
 public function index()
 {
     return $this->renderer->render("@home/home");
 }
}