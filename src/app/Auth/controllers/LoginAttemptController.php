<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Controllers\RouterAwareController;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use G1c\Culturia\framework\Validator;

class LoginAttemptController
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

    public function __invoke(): RedirectResponse|string
    {
        $errors = null;
        $params = $_POST;
        $params = array_filter($params, function ($key){
            return in_array($key, ["email", "password", "role"]);
        }, ARRAY_FILTER_USE_KEY);
        $validator = (new Validator($params))
            ->required('email', 'password', "role")
            ->length("email", 3, 255)
            ->length("password", 3, 2000);
        try {
            $user = $this->auth->login($params['email'], $params['password'], $params["role"]);
        } catch (NoRecordException $e){
            $user = null;
        }
        if(!$user) {
            (new FlashService($this->session))->error("Identifiants Invalides");
            $errors = $validator->getErrors();
            return $this->renderer->render("@auth/login", compact("errors", "params"));
        } else {
            (new FlashService($this->session))->success("Connexion réussie");
            $route_name = $params["role"] == 1 ? 'auth.index' : 'artists.profile';
            $path = $this->session->get("auth.redirect") ?: $this->router->generateUri($route_name, ["id" => $user->id]);
            $this->session->delete("auth.redirect");
            return new RedirectResponse($path);
        }
    }
}