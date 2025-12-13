<?php
use G1c\Culturia\app\App;
use G1c\Culturia\app\Shop\ShopModule;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";


$app = new App(dirname(__DIR__). '/config/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
ini_set("html_errors", 'On');
ini_set('error_prepend_string', "<pre>");
ini_set("error_append_string", "</pre>");



$app->add(ShopModule::class);
if (php_sapi_name() !== 'cli') {
    $response = $app->run($_REQUEST);
}