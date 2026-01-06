<?php

namespace G1c\Culturia\framework\Renderer\Extensions;

use G1c\Culturia\framework\Middlewares\CsrfMiddleware;
use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;

class CsrfExtension implements RendererExtensionInterface
{

    private CsrfMiddleware $csrfMiddleware;

    public function __construct(CsrfMiddleware $csrfMiddleware)
    {

        $this->csrfMiddleware = $csrfMiddleware;
    }
    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("csrf_input", [$this, "csrfInput"]);
    }

    public function csrfInput()
    {
        return '<input type="hidden" name="'.$this->csrfMiddleware->getFormKey().'" value="'. $this->csrfMiddleware->generateToken() . '">';
    }
}