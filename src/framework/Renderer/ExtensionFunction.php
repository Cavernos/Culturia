<?php

namespace G1c\Culturia\framework\Renderer;

class ExtensionFunction
{
    private string $name;
    /**
     * @var callable
     */
    private $function;

    public function __construct(string $name, callable $function)
    {

        $this->name = $name;
        $this->function = $function;
    }

    public function getFunction(): callable
    {
        return $this->function;
    }

    public function getName(): string
    {
        return $this->name;
    }
}