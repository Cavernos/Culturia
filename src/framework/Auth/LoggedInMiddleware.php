<?php

namespace G1c\Culturia\framework\Auth;

use G1c\Culturia\app\Artists\model\ArtistsModel;
use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\framework\Auth;

class LoggedInMiddleware
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    public function __invoke($request, callable $next)
    {
        $user = $this->auth->getUser();
        $userTypes = ["clients", "artists"];
        if(isset($request["prefix"])) {
            $prefix = $request["prefix"];
            foreach ($userTypes as $type) {
                if(str_contains($prefix, $type)) {
                    if($type == "clients") {
                        if(is_null($user) || !$user->is(ClientModel::class)){
                            throw new ForbiddenException("client");
                        }
                    } elseif ($type == "artists") {
                        if(is_null($user) || !$user->is(ArtistsModel::class)){
                            throw new ForbiddenException("artistes");
                        }
                    }
                }
            }
        }

        $request['user'] = $user;
        return $next($request);

    }
}