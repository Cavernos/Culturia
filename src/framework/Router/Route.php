<?php namespace G1c\Culturia\framework\Router;

use G1c\Culturia\framework\Container;

class Route {
    protected $path;
    protected $name;
    protected $callback;
    private $matches;


    public function __construct(string $path, callable|string $callback, ?string $name)
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
        $url = explode("?", trim($url, "/"))[0];
        $path = preg_replace_callback("#\{[\w]+:([^}]+)}#", [$this, "paramMatch"], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true; 
    }

    public function getUrl(array $params): string
    {
        $path = $this->path;
        foreach ($params as $key => $value){
            $path = preg_replace("#\{$key:([^}]+)}#", $value, $path);
        }
        return $path;
    }

    private function paramMatch($match) {
        return '(' . $match[1] . ')';
        //'([^/+])'   
    }


    public function call() {
        if (is_string($this->callback)){
            $controller = Container::getInstance()->get($this->callback);
            if(!is_null($this->name)){
                $name = explode(".", $this->name);
                if(method_exists($controller, $name[1])){
                    return call_user_func_array([$controller, $name[1]], $this->matches);
                }
            }
            return call_user_func($controller, $this->matches);
        }
        return call_user_func_array($this->callback, $this->matches);
        
        
     }



}