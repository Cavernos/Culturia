<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\framework\Exception\CsrfInvalidException;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Session\FlashService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class InvalidCsrfMiddleware
{
    private FlashService $flashService;

    public function __construct(FlashService $flashService)
    {

        $this->flashService = $flashService;
    }
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        try {
            return $next($request);
        } catch (CsrfInvalidException $e) {
            $this->flashService->error("Le token CSRF est invalide, veuillez réessayer");
            return new RedirectResponse($request->getUri()->getPath());

        }
    }

}