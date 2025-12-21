<?php
use G1c\Culturia\app\App;
use G1c\Culturia\app\Auth\AuthModule;
use G1c\Culturia\app\Home\HomeModule;
use G1c\Culturia\app\Shop\ShopModule;
use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Middlewares\RouterMiddleware;
use G1c\Culturia\framework\Middlewares\TrailingSlashMiddleware;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";



$app = new App(dirname(__DIR__). '/config/config.php');



$app->add(ShopModule::class)
    ->add(AuthModule::class)
    ->add(HomeModule::class);

$app->pipe(TrailingSlashMiddleware::class)
->pipe(RouterMiddleware::class);
if (php_sapi_name() !== 'cli') {
    $response = $app->run($_SERVER);
}
