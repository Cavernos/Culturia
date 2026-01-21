<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Auth\ForbiddenException;
use G1c\Culturia\framework\Auth\LoggedInMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class ClientLoggedInMiddleware extends LoggedInMiddleware
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    public function __invoke(ServerRequestInterface $request, callable $next): mixed
    {
        $user = $this->auth->getUser();
        if(!$user || !$user->is(ClientModel::class)) {
            throw new ForbiddenException("Vous devez être connecté en tant que client pour voir cette page");
        }
        $request->withAttribute('user', $user);
        return $next($request);
    }

}