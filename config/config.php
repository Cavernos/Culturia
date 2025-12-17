<?php

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Renderer\RendererPaginationExtension;
use G1c\Culturia\framework\Renderer\RendererRouterExtension;

return [
    'view.path' => dirname(__DIR__) .DIRECTORY_SEPARATOR."views",
    "database.hostname" => "localhost",
    "database.port" => "3306",
    "database.username" => "root",
    "database.password" => "",
    "database.name" => "culturia_test",
    PDO::class => function (Container $c){
        return new PDO('mysql:host=' . $c->get("database.hostname") . ';dbname=' . $c->get("database.name"), $c->get("database.username"), $c->get("database.password"),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    },
    "renderer.extensions" => function  (Container $c) {
        return [
            $c->get(RendererRouterExtension::class),
            $c->get(RendererPaginationExtension::class),
        ];

    }
];