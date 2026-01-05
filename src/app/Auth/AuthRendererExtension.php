<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;

class AuthRendererExtension implements RendererExtensionInterface
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {

        $this->auth = $auth;
    }
    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("current_user", [$this->auth, "getUser"]);
    }
}