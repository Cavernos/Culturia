<?php namespace G1c\Culturia\app\Home;


use G1c\Culturia\app\Home\controllers\HomeController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class HomeModule {
    const DEFINITIONS = __DIR__ . "/config.php";
    private Renderer $renderer;

    public function __construct(string $prefix, Router $router, Renderer $renderer){

        $this->renderer = $renderer;
        $this->renderer->addPath("home", __DIR__ . "/views");
        $router->get($prefix, HomeController::class, "home.index");
    }

}