<?php

namespace G1c\Culturia\framework\Renderer\Extensions;

use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;
use G1c\Culturia\framework\Session\FlashService;

class FlashExtension implements RendererExtensionInterface
{

    private FlashService $flash;

    public function __construct(FlashService $flash)
    {

        $this->flash = $flash;
    }

    public function getFunctions(): ExtensionFunction
    {
       return new ExtensionFunction("flash", [$this, "getFlash"]);
    }

    public function getFlash(string $type): ?string
    {
        return $this->flash->get($type);
    }
}