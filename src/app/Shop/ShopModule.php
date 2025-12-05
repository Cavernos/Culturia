<?php namespace G1c\Culturia\app\Shop;

use G1c\Culturia\app\Shop\controllers\ShopController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router;

class ShopModule {
    const DEFINITIONS = __DIR__ . '/config.php';

    private $renderer;

    public function __construct(string $prefix, Router $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('shop', __DIR__ . '/views');
        $router->get($prefix, ShopController::class, 'shop.index');
    }

}