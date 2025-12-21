<?php namespace G1c\Culturia\app;

use Exception;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Renderer\RendererFactory;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Router\RouterException;

class App {

    
    private Container $container;
    /**
     * @var array
     */
    private array $modules = [];

    private array $middlewares = [];

    private int $index = 0;
    private string $definition;

    public function __construct(string $definition){
        $this->definition = $definition;


    }
    public function getContainer(): Container
    {
        $container = Container::getInstance();
        $container->addDefinition($this->definition);
        foreach($this->modules as $module){
            if($module::DEFINITIONS){
                $container->addDefinition($module::DEFINITIONS);
            }    
        }
        $this->container = $container;
        return $this->container;

    }
    public function add(string $module): self {
        $this->modules[] = $module;
        return $this;
    }

    public function pipe(string $routePrefix, ?string $middleware = null) {
        if(is_null($middleware)){
            $this->middlewares[] = $routePrefix;
        }

        return $this;
    }
    public function handle(mixed $request){
        $middleware = $this->getMiddleware();
        if (is_callable($middleware)){
            return call_user_func_array($middleware, [$request, [$this, 'handle']]);
        }
        if (is_null($middleware)){
            throw new Exception("Aucun middleware n'a intercepté votre requête");
        }

    }
    public function run(array $request){
        foreach ($this->modules as $module){
            $this->getContainer()->get($module);
        }
        return $this->handle($request); 
       
    }

    private function getMiddleware()
    {
        if (array_key_exists($this->index, $this->middlewares)){
            if (is_string($this->middlewares[$this->index])){
                $middleware = $this->container->get($this->middlewares[$this->index]);
            } else {
                $middleware = $this->middlewares[$this->index];
            }
            $this->index++;
            return $middleware;
        }
        return null;
    }

    public function getModules() {
        return $this->modules;
        
    }
}