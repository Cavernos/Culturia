<?php

use G1c\Culturia\app\Home\HomeModule;
use G1c\Culturia\framework\Container;

return [
    "home.prefix" => "/",
    HomeModule::class => function (Container $c) {
        return $c->resolve(HomeModule::class, "home.prefix");
    }
];
