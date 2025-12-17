<?php

namespace G1c\Culturia\framework\Renderer;

use G1c\Culturia\framework\Router\Router;

class RendererRouterExtension implements RendererExtensionInterface
{
    private Router $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }
    public function getFunctions(): array
    {
        return [$this, "pathFor"];

    }

    public function pathFor($name, $params = [], $queryParams = []){
        return $this->router->generateUri($name, $params, $queryParams);
    }

}