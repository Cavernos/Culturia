<?php

namespace G1c\Culturia\framework\Renderer\Extensions;

use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;
use G1c\Culturia\framework\Router\Router;

class FilterExtension implements RendererExtensionInterface
{

    private array $filters = ["price", "artists", "years"];
    private Router $router;

    public function __construct(Router $router){

        $this->router = $router;
    }
    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("filter", [$this, "filter"]);
    }

    public function filter(?string $name, string $label, string $path, array $request, ?array $options = []): string
    {
        $filters = array_diff_key($request, array_flip($this->filters));
        if(!is_null($name)){
            $request[$name] = (isset($request[$name]) && $request[$name] === "desc") ? "asc" : "desc";

            $uri = $this->router->generateUri(
                $path,
                [],
                array_merge($filters, [$name => $request[$name]]));
        } else {
            $uri = $this->router->generateUri($path, [], $filters);
        }

        $classNames = ["button"];
        if(isset($options["type"])){
            if($options['type'] === "toggle") {
                $classNames = array_merge($classNames, ["iconify-button", "filter-button", $request[$name]]);
            } elseif($options['type'] === "reset") {
                $classNames[] = "reset";
            }
        }
        $className = join(" ", $classNames);

        return "<a href='$uri' class='{$className}'>
            $label
        </a>";

    }
}