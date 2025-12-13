<?php namespace G1c\Culturia\framework;

use G1c\Culturia\framework\Router\Route;

class Router {
    private $paths = [];

    public function __construct()
    {
    }

    public function get($path, $callback, $name){
        array_push($this->paths, new Route('GET', $path, $callback));
    }

    public function match(){
        foreach ($this->paths as $key => $value){
            if ($value->getMethod() === $_SERVER["REQUEST_METHOD"]){
                if(str_contains($_SERVER["REQUEST_URI"], $value->getName())){
                     return call_user_func_array(new ($value->getCallback())(), array(Container::getInstance()->get(Renderer::class), 'tr'));
                }
               
            }
        }
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        return die();
    }
        
    
}