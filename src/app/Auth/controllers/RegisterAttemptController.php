<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Artists\model\ArtistsModel;
use G1c\Culturia\app\Auth\DatabaseAuth;
use G1c\Culturia\framework\Controllers\RouterAwareController;
use G1c\Culturia\framework\Logger;
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
    private Logger $logger;

    use RouterAwareController;

    public function __construct(Renderer $renderer, Logger $logger, SessionInterface $session, DatabaseAuth $auth, Router $router)
    {

        $this->renderer = $renderer;
        $this->session = $session;
        $this->auth = $auth;
        $this->router = $router;
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request): string|ResponseInterface
    {
        $errors = null;
        $params = $request->getParsedBody();
        $table = $this->auth->getTable($params["role"]);
        $validator = (new Validator($params))
            ->required("username", "email", "password", "password2", "cgu", "role")
            ->length("email", 3, 255)
            ->length("username", 3, 255)
            ->length("password", 3, 2000)
            ->exists("email", $table->getTable(), $table->getPdo())
            ->exists("username", $table->getTable(), $table->getPdo())
            ->same("password", "password2");
        $errors = $validator->getErrors();
        $user = false;
        if (count($errors) === 0){
            $user = $this->auth->register($params);
        }
        if($user) {
            $uri = "auth.index";
            if($user->is(ArtistsModel::class)){
                $uri = "artists.profile";
            }
            $path = $this->session->get('auth.redirect') ?: $this->router->generateUri($uri, ["id"=> $user->id]);
            $this->session->delete("auth.redirect");
            $this->logger->info("Enregistrement d'un utilisateur" . $user->getUsername());
            (new FlashService($this->session))->success("Enregistrement réussi");
            return new RedirectResponse($path);
        } else {
            $this->logger->error("Enregistrement d'un utilisateur échoué");

            (new FlashService($this->session))->error("Enregistrement invalide");
            return $this->renderer->render("@auth/register", compact("errors", "params"));
        }

    }
}