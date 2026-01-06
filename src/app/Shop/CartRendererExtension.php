<?php

namespace G1c\Culturia\app\Shop;

use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;
use G1c\Culturia\framework\Session\SessionInterface;

class CartRendererExtension implements RendererExtensionInterface
{
    private SessionInterface $session;
    private Auth $auth;

    public function __construct(SessionInterface $session, Auth $auth)
    {

        $this->session = $session;
        $this->auth = $auth;
    }

    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("cart_count", [$this, "count"]);
    }

    public function count(): int {
        $user = $this->auth->getUser();
        $carts = $this->session->get("carts", []);
        if(!is_null($user) && isset($carts[$user->id])) {
            return count($carts[$user->id]);
        }
        return 0;
    }
}