<?php

namespace G1c\Culturia\framework\Controllers;

use G1c\Culturia\framework\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

trait RouterAwareController
{
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return (new RedirectResponse($redirectUri))
            ->withStatus(301)
            ->withHeader('Location', $redirectUri);
    }
}