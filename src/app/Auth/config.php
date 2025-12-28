<?php

use G1c\Culturia\app\Auth\AuthModule;
use G1c\Culturia\app\Auth\AuthRendererExtension;
use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Container;

return [
    "auth.login" => "/login",
    "auth.register" => "/register",
    AuthModule::class => function (Container $container) {
        return new AuthModule($container);

    },
    "renderer.extensions" => [
        AuthRendererExtension::class
    ],
    Auth::class => function (Container $c) {
        return $c->resolve(DatabaseAuth::class);
    }
];