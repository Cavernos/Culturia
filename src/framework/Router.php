<?php namespace G1c\Culturia\framework;
use G1c\Culturia\framework\Router\Route;

class Router {
    private $renderer;
    private $paths = [];
    private $path;
    public $callback;
    private $name;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function get($path, $callback, $name){
       $this->path = $path;
       $this->callback = $callback;
       $this->name = $name;
    }
    public function match(){
         return call_user_func_array(new $this->callback, array($this->renderer, 'toto'));
    }
        
    
}