<?php namespace G1c\Culturia\framework\Router;

use G1c\Culturia\framework\Router\Route;

class Router {
    private $paths = [];
    private $namedRoute = [];

    public function __construct()
    {
    }

    public function get($path, $callback, $name =null){
        $this->add($path, $callback, $name, "GET");
    }
    public function post($path, $callback, $name =null){
        $this->add($path, $callback, $name, "POST");
    }

    public function add(string $path, callable|string $callback,string $name, string $method){
        $route = new Route($path,$callback, $name);
        $this->paths[$method][] = $route;
        if (is_string($callback) && $name === null){
            $name = $callback;
        }
        if($name){
            $this->namedRoute[$name] = $route; 
        }
    }
    public function match(string $url){
        if (!isset($this->paths[$_SERVER["REQUEST_METHOD"]])){
            throw new RouterException($_SERVER["REQUEST_METHOD"] . "does not exist in paths");
        }
        foreach ($this->paths[$_SERVER["REQUEST_METHOD"]] as $key => $value){
            if ($value->match($url)){
                return $value->call();
            }
        }
        throw new RouterException("No route match with $url");
        
    }

    public function generateUri(string $name,array $params = [],array $queryParams = []): string
    {
        if (!isset($this->namedRoute[$name])){
            return '';
        }
        $uri = "/". $this->namedRoute[$name]->getUrl($params);
        if (!empty($queryParams)){
            return $uri . "?" . http_build_query($queryParams);
        }
        return $uri;

    }

        
    
}