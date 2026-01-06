<?php

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Middlewares\CsrfMiddleware;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Renderer\Extensions\CsrfExtension;
use G1c\Culturia\framework\Renderer\Extensions\FilterExtension;
use G1c\Culturia\framework\Renderer\Extensions\FlashExtension;
use G1c\Culturia\framework\Renderer\Extensions\FormExtension;
use G1c\Culturia\framework\Renderer\Extensions\RendererPaginationExtension;
use G1c\Culturia\framework\Renderer\Extensions\RendererRouterExtension;
use G1c\Culturia\framework\Renderer\RendererFactory;
use G1c\Culturia\framework\Session\PHPSession;
use G1c\Culturia\framework\Session\SessionInterface;

return [
    'view.path' => dirname(__DIR__) .DIRECTORY_SEPARATOR. "views",
    "database.hostname" => "localhost",
    "database.port" => "3306",
    "database.username" => "root",
    "database.password" => "",
    "database.name" => "culturia_test",
    "env" => getenv("ENV") ?: "production",
    "log.path" => dirname(__DIR__) . DIRECTORY_SEPARATOR . "app.log",
    PDO::class => function (Container $c){
        return new PDO('mysql:host=' . $c->get("database.hostname") . ';dbname=' . $c->get("database.name"), $c->get("database.username"), $c->get("database.password"),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    },
    "renderer.extensions" => [
        RendererRouterExtension::class,
        RendererPaginationExtension::class,
        FormExtension::class,
        FlashExtension::class,
        FilterExtension::class,
        CsrfExtension::class

    ],
    SessionInterface::class => new PHPSession(),
    CsrfMiddleware::class => function (Container $c){
        $session = $c->get(SessionInterface::class);
        return new CsrfMiddleware($session);},
    Renderer::class => Container::getInstance()->factory(RendererFactory::class),
    Logger::class => fn(Container $c) => new Logger($c->get("env"), $c->get("log.path"))
];