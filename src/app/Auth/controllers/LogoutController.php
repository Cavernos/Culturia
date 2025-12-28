<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Controllers\RouterAwareController;
use G1c\Culturia\framework\Router\Router;

class LogoutController
{
    private DatabaseAuth $auth;
    private Router $router;
    use RouterAwareController;

    public function __construct(DatabaseAuth $auth, Router $router)
    {

        $this->auth = $auth;
        $this->router = $router;
    }

    public function __invoke()
    {
        $this->auth->logout();
        $this->redirect("home.index");

    }
}