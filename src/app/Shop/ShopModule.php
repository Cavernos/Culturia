<?php namespace G1c\Culturia\app\Shop;

use G1c\Culturia\app\Shop\controllers\ShopController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class ShopModule {
    const DEFINITIONS = __DIR__ . '/config.php';

    private $renderer;

    public function __construct(string $prefix, Router $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('shop', __DIR__ . '/views');
        $router->get($prefix, ShopController::class, 'shop.index');
        $router->post($prefix . "/new", ShopController::class, 'shop.create');
        $router->get($prefix . "/{slug:[a-z\-0-9]+}-{id:[0-9]+}", ShopController::class, 'shop.view');

    }

}