<?php

namespace G1c\Culturia\framework\Controllers;

trait RouterAwareController
{
    public function redirect(string $path, array $params = []):void
    {
        $redirectUri = $this->router->generateUri($path, $params);
        header("Location: $redirectUri", 301);
    }
}