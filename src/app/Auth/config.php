<?php

use G1c\Culturia\app\Auth\AuthModule;
use G1c\Culturia\framework\Container;

return [
    "auth.login" => "/login",
    "auth.register" => "/register",
    AuthModule::class => function (Container $container) {
        return new AuthModule($container);

    }
];