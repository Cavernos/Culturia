<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Controllers\RouterAwareController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use G1c\Culturia\framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function __invoke(ServerRequestInterface $request): string|ResponseInterface
    {
        $errors = null;
        $params = $request->getParsedBody();
        $validator = (new Validator($params))
            ->required("username", "email", "password", "password2", "cgu", "role")
            ->length("email", 3, 255)
            ->length("username", 3, 255)
            ->length("password", 3, 2000)
            ->same("password", "password2");
        $errors = $validator->getErrors();
        $user = false;
        if (count($errors) === 0){
            $user = $this->auth->register($params);
        }
        if($user) {
            $path = $this->session->get('auth.redirect') ?: $this->router->generateUri("auth.index", ["id"=> $user->id]);
            $this->session->delete("auth.redirect");
            (new FlashService($this->session))->success("Enregistrement réussi");
            return new RedirectResponse($path);
        } else {
            (new FlashService($this->session))->error("Enregistrement invalide");
            return $this->renderer->render("@auth/register", compact("errors", "params"));
        }

    }
}