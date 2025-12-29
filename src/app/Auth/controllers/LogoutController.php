<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Controllers\RouterAwareController;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;

class LogoutController
{
    private DatabaseAuth $auth;
    private Router $router;
    private FlashService $flash;
    use RouterAwareController;

    public function __construct(DatabaseAuth $auth, Router $router, FlashService $flash)
    {

        $this->auth = $auth;
        $this->router = $router;
        $this->flash = $flash;
    }

    public function __invoke()
    {
        $this->auth->logout();
        $this->flash->success("Déconnexion réussie");
        $this->redirect("home.index");

    }
}