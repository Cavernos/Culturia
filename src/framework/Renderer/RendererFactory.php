<?php

namespace G1c\Culturia\framework\Renderer;

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Renderer;

class RendererFactory
{
    public function __invoke(Container $container): Renderer
    {
        $renderer = new Renderer();
        $renderer->addGlobal("layout_path", $container->get('view.path') . DIRECTORY_SEPARATOR. "layout.php");
        if ($container->has("renderer.extensions")){
                $extensions = $container->get("renderer.extensions");
                foreach ($extensions as $extension) {
                    $renderer->addExtension($container->get($extension));
                }
        }
        return $renderer;
    }

}