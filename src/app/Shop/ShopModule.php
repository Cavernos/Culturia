<?php namespace G1c\Culturia\app\Shop;

use G1c\Culturia\app\Shop\controllers\CartCrudController;
use G1c\Culturia\app\Shop\controllers\ShopController;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Module;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\SessionInterface;

class ShopModule extends Module {
    const DEFINITIONS = __DIR__ . '/config.php';

    public const MIGRATIONS = __DIR__ . "/db/migrations";

    const SEEDS = __DIR__ . "/db/seeds";

    private Renderer $renderer;

    public function __construct(Container $c)
    {
        $c->get(Logger::class)->setChannel("shop");
        $this->renderer = $c->get(Renderer::class);
        $this->renderer->addPath('shop', __DIR__ . '/views');
        /**
         * Add new routes
         */
        $prefix = $c->get("shop.prefix");
        $router = $c->get(Router::class);
        $router->get($prefix, ShopController::class, 'shop.index');
        $router->get($prefix . "/{slug:[a-z\-0-9]+}-{id:[0-9]+}", ShopController::class, 'shop.view');
        if($c->has("admin.prefix")){
            $router->crud($c->get("admin.prefix") . $prefix . "/cart", CartCrudController::class, 'shop.cart');
        }

    }

}