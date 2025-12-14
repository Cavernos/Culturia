<?php namespace G1c\Culturia\framework\Router;

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Renderer;

class Route {
    protected $path;
    protected $name;
    protected $callback;
    private $matches;


    public function __construct(string $path, callable|string $callback, string $name)
    {
        $this->path = trim($path, "/");
        $this->name = $name;
        $this->callback = $callback;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getCallback(): callable|string {
        return $this->callback;
    }

    public function match(string $url) : bool {
        $url = trim($url, "/");
        $path = preg_replace_callback("#\{[\w]+:([^}]+)\}#", [$this, "paramMatch"], $this->path);
        var_dump($path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true; 
    }
    private function paramMatch($match) {
        return '(' . $match[1] . ')';
        //'([^/+])'   
    }

    public function call() {
        if (is_string($this->callback)){
            $controller = new ($this->callback)(Container::getInstance()->get(Renderer::class));
            if(!is_null($this->name)){
                $name = explode(".", $this->name);
                return call_user_func_array([$controller, $name[1]], $this->matches);
            }
            return call_user_func($controller);
        }
        return call_user_func_array($this->callback, $this->matches);
        
        
     }



}