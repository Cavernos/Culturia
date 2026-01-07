<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\framework\Auth\ForbiddenException;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;

class ForbiddenMiddleware
{
    private $loginPath;
    private SessionInterface $session;
    private Router $router;

    public function __construct(string $loginPath, SessionInterface $session, Router $router)
    {

        $this->loginPath = $loginPath;
        $this->session = $session;
        $this->router = $router;
    }
 public function __invoke($request, callable $next) {
        try {
            return $next($request);
        } catch (ForbiddenException $e)
        {
            $accountType = $e->getAccountType();
            $this->session->set('auth.redirect', parse_url($request["REQUEST_URI"], PHP_URL_PATH));
            (new FlashService($this->session))->error("Vous devez être un $accountType pour accéder à cette page");
            var_dump($this->loginPath);
            header("Location: $this->loginPath");
            return exit();
        }
 }
}