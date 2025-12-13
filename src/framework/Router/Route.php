<?php namespace G1c\Culturia\framework\Router;
class Route {
    protected $name;
    protected $callback;
    protected $method;

    public function __construct(string $method, string $name, callable|string $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->method = $method;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getCallback(): callable|string {
        return $this->callback;
    }

    public function getMethod(): string {
        return $this->method;
    }



}