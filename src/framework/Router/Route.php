<?php namespace G1c\Culturia\framework\Router;
class Route {
    protected $name;
    protected $callback;
    protected $params;

    public function __construct(string $name, callable|string $callback, array $params)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getCallback():callable|string{
        return $this->callback;
    }

    public function getParams(): array {
        return $this->params;
    }



}