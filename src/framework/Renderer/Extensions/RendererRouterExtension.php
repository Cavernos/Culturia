<?php

namespace G1c\Culturia\framework\Renderer\Extensions;

use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;
use G1c\Culturia\framework\Router\Router;

class RendererRouterExtension implements RendererExtensionInterface
{
    private Router $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }
    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("pathFor", [$this, "pathFor"]);

    }

    public function pathFor($name, $params = [], $queryParams = []){
        return $this->router->generateUri($name, $params, $queryParams);
    }

}