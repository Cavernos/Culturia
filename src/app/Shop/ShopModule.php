<?php namespace G1c\Culturia\app\Shop;

use G1c\Culturia\app\Shop\controllers\ShopController;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Module;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class ShopModule extends Module {
    const DEFINITIONS = __DIR__ . '/config.php';

    private Renderer $renderer;

    public function __construct(Container $c)
    {
        $this->renderer = $c->get(Renderer::class);
        $this->renderer->addPath('shop', __DIR__ . '/views');

        /**
         * Add new routes
         */
        $prefix = $c->get("shop.prefix");
        $router = $c->get(Router::class);
        $router->get($prefix, ShopController::class, 'shop.index');
        $router->get($prefix . "/{slug:[a-z\-0-9]+}-{id:[0-9]+}", ShopController::class, 'shop.view');

    }

}