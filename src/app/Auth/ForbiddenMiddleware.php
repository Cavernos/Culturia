<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\framework\Auth\ForbiddenException;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

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
 public function __invoke(ServerRequestInterface $request, callable $next) {
        try {
            return $next($request);
        } catch (ForbiddenException $e)
        {
            $this->session->set('auth.redirect', $request->getUri()->getPath());
            (new FlashService($this->session))->error("Vous devez être connecté pour accéder à cette page");
            return new RedirectResponse($this->loginPath);
        }
 }
}