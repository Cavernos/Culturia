<?php namespace G1c\Culturia\framework\Router;


use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
    public function update($path, $callback, $name = null){
        $this->add($path, $callback, $name, "UPDATE");
    }

    public function delete($path, $callback, $name = null){
        $this->add($path, $callback, $name, "DELETE");
    }

    public function crud($path, $callback, $name = null)
    {
        $this->get("$path", $callback, "$name.index");
        $this->get("$path/new", $callback, "$name.create");
        $this->post("$path/new", $callback);
        $this->get("$path/{id:\d+}", $callback, "$name.edit");
        $this->post("$path/{id:\d+}", $callback);
        $this->delete("$path/{id:\d+}", $callback, "$name.delete");
    }

    public function add(string $path, callable|string $callback,?string $name, string $method){
        $route = new Route($path,$callback, $name);
        $this->paths[$method][] = $route;
        if (is_string($callback) && $name === null){
            $name = $callback;
        }
        if($name){
            $this->namedRoute[$name] = $route; 
        }
    }
    public function match(ServerRequestInterface $request): ResponseInterface
    {
        if (!isset($this->paths[$request->getMethod()])){
            throw new RouterException($request->getMethod() . "does not exist in paths");
        }
        foreach ($this->paths[$request->getMethod()] as $key => $value){
            if ($value->match($request->getUri()->getPath())){
                return new Response(200, [], $value->call($request));
            }
        }
        throw new RouterException("No route match with ". $request->getUri()->getPath());
        
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