<?php

use G1c\Culturia\app\App;
use G1c\Culturia\app\Artists\ArtistsModule;
use G1c\Culturia\app\Auth\AuthModule;
use G1c\Culturia\app\Auth\ForbiddenMiddleware;
use G1c\Culturia\app\Home\HomeModule;
use G1c\Culturia\app\Shop\ShopModule;
use G1c\Culturia\framework\Auth\LoggedInMiddleware;
use G1c\Culturia\framework\Middlewares\CsrfMiddleware;
use G1c\Culturia\framework\Middlewares\MethodMiddleware;
use G1c\Culturia\framework\Middlewares\NotFoundMiddleware;
use G1c\Culturia\framework\Middlewares\RouterMiddleware;
use G1c\Culturia\framework\Middlewares\TrailingSlashMiddleware;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";



$app = new App(dirname(__DIR__). '/config/config.php');
$app->add(ShopModule::class)
    ->add(AuthModule::class)
    ->add(HomeModule::class)
    ->add(ArtistsModule::class);

$container = $app->getContainer();
$app->pipe(TrailingSlashMiddleware::class)
    ->pipe(MethodMiddleware::class)
    ->pipe(CsrfMiddleware::class)
    ->pipe(ForbiddenMiddleware::class)
    ->pipe($container->get("artists.prefix"), LoggedInMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(NotFoundMiddleware::class);
if (php_sapi_name() !== 'cli') {
    $response = $app->run($_SERVER);
}
