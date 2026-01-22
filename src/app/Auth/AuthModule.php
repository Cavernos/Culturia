<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\app\Auth\controllers\AuthController;
use G1c\Culturia\app\Auth\controllers\Crud\CartCrudController;
use G1c\Culturia\app\Auth\controllers\Crud\FavoriteCrudController;
use G1c\Culturia\app\Auth\controllers\Crud\OrderCrudController;
use G1c\Culturia\app\Auth\controllers\LoginAttemptController;
use G1c\Culturia\app\Auth\controllers\LoginController;
use G1c\Culturia\app\Auth\controllers\LogoutController;
use G1c\Culturia\app\Auth\controllers\ProfileController;
use G1c\Culturia\app\Auth\controllers\RegisterAttemptController;
use G1c\Culturia\app\Auth\controllers\RegisterController;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Module;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\SessionInterface;

class AuthModule extends Module
{
    const DEFINITIONS = __DIR__ . "/config.php";

    public const MIGRATIONS = __DIR__ . "/db/migrations";

    public const SEEDS = __DIR__ . "/db/seeds";

     public function __construct(Container $container)
     {
        $container->get(Renderer::class)->addPath("auth", __DIR__ . "/views");
        $router = $container->get(Router::class);
        $router->get("/cgu", AuthController::class, "auth.cgu");
         $router->post("/logout", LogoutController::class, "auth.logout");
         $client_prefix = $container->get("auth.prefix");
         $router->get($client_prefix . "/{id:[0-9]+}", ProfileController::class, 'auth.index').

         $router->get($client_prefix . "/{id:[0-9]+}/edit", ProfileController::class, 'auth.edit');
         $router->post($client_prefix . "/{id:[0-9]+}/edit", ProfileController::class);
         $router->delete($client_prefix . "/{id:[0-9]+}", ProfileController::class, "auth.delete");

         $router->post($client_prefix . "/orders/new", OrderCrudController::class, "client.orders.create");


         $router->crud($client_prefix . "/favorite", FavoriteCrudController::class, 'client.favorite');
         $router->crud( $client_prefix . "/cart", CartCrudController::class, 'client.cart');

         $router->get($container->get("auth.login"), LoginController::class, "auth.login");
         $router->post($container->get("auth.login"), LoginAttemptController::class);
         $router->get($container->get("auth.register"), RegisterController::class, "auth.register");
         $router->post($container->get("auth.register"), RegisterAttemptController::class);
     }
}