<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Controllers\RouterAwareController;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use G1c\Culturia\framework\Validator;

class RegisterAttemptController
{
    private Renderer $renderer;
    private SessionInterface $session;
    private DatabaseAuth $auth;
    private Router $router;

    use RouterAwareController;

    public function __construct(Renderer $renderer, SessionInterface $session, DatabaseAuth $auth, Router $router)
    {

        $this->renderer = $renderer;
        $this->session = $session;
        $this->auth = $auth;
        $this->router = $router;
    }

    public function __invoke()
    {
        $errors = null;
        $params = $_POST;
        $validator = (new Validator($params))
            ->required("username", "email", "password", "password2", "cgu")
            ->length("email", 3, 255)
            ->length("username", 3, 255)
            ->length("password", 3, 2000)
            ->same("password", "password2");
        ;
        $errors = $validator->getErrors();
        $user = false;
        if (count($errors) === 0){
            $user = $this->auth->register($params);
        }
        if($user) {
            $path = $this->session->get('auth.redirect') ?: "home.index";
            $this->session->delete("auth.redirect");
            (new FlashService($this->session))->success("Enregistrement réussi");
            $this->redirect($path);
        } else {
            (new FlashService($this->session))->error("Identifiants Invalides");
            return $this->renderer->render("@auth/register", compact("errors", "params"));
        }

    }
}