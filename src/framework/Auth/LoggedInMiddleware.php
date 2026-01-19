<?php

namespace G1c\Culturia\framework\Auth;

use G1c\Culturia\app\Artists\model\ArtistsModel;
use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\framework\Auth;
use Psr\Http\Message\ServerRequestInterface;

class LoggedInMiddleware
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $user = $this->auth->getUser();
       if(!$user) {
           throw new ForbiddenException();
       }

        $request->withAttribute('user', $user);
        return $next($request);

    }
}