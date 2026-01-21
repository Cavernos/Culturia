<?php

namespace G1c\Culturia\framework\Auth;

use G1c\Culturia\app\Artists\model\ArtistsModel;
use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\framework\Auth;
use Psr\Http\Message\ServerRequestInterface;

class LoggedInMiddleware
{
    protected Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param ServerRequestInterface $request
     * @param callable $next
     * @return mixed
     * @throws ForbiddenException
     */
    public function __invoke(ServerRequestInterface $request, callable $next): mixed
    {
        $user = $this->auth->getUser();
       if(!$user) {
           throw new ForbiddenException("Vous devez être connecté pour accéder à cette page");
       }
        $request->withAttribute('user', $user);
        return $next($request);

    }
}