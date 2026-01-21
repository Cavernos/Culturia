<?php namespace G1c\Culturia\app\Shop;

use G1c\Culturia\app\Shop\controllers\ShopController;
use G1c\Culturia\app\Shop\controllers\ShopCrudController;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Module;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class ShopModule extends Module {
    const string DEFINITIONS = __DIR__ . '/config.php';

    public const string MIGRATIONS = __DIR__ . "/db/migrations";

    const string SEEDS = __DIR__ . "/db/seeds";

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
            $admin_prefix = $c->get("admin.prefix");

            $router->crud($admin_prefix . $prefix . "/artwork", ShopCrudController::class, 'admin.artworks');
        }

    }

}