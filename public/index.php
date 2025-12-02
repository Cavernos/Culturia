<?php
use G1c\Culturia\app\App;
use G1c\Culturia\app\Home\HomeModule;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";

$app = new App();
$app->add(new HomeModule());


if (php_sapi_name() !== 'cli') {
    $response = $app->run();
}