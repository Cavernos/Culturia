<?php

namespace G1c\Culturia\framework\Renderer\Extensions;

use G1c\Culturia\framework\Paginator;
use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;
use G1c\Culturia\framework\Router\Router;

class RendererPaginationExtension implements RendererExtensionInterface
{

    private Router $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }
    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("paginate", [$this, "paginate"]);
    }

    public function paginate(Paginator $paginator,
                             string $route,
                             array $routerOptions = []): string
    {
        $html_paginator[] = '<div class="pagination-container">';
        $html_paginator[] = '
        <a href="'. $this->router->generateUri($route, $routerOptions, ["p" => $paginator->previous()]).'" class="button iconify-button left-pagination-button"></a>';
        for ($i =1; $i < $paginator->getTotalPages() + 1; $i++){
            $html_paginator[] = "<a href='" . $this->router->generateUri($route, $routerOptions,  ["p" => $i]) . "' class='button pagination'>$i</a>";
        }
        $html_paginator[] = '<a href="'. $this->router->generateUri($route, $routerOptions,  ["p" => $paginator->next()]).'" class="button iconify-button right-pagination-button"></a>';
        $html_paginator[] = '</div>';
        return join(' ', $html_paginator);
    }









}