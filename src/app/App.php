<?php namespace G1c\Culturia\app;

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Renderer\RendererFactory;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Router\RouterException;

class App {

    
    private $container;
    /**
     * @var array
     */
    private $modules = [];
    private $definition;

    public function __construct(string $definition){
        $this->definition = $definition;


    }
    public function getContainer(): Container
    {
        $container = Container::getInstance($this->definition);
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
    public function handle(mixed $request){
        try{
            $match = Container::getInstance()->get(Router::class)->match($_SERVER["REQUEST_URI"]);
            return $match;
        } catch (RouterException $exception){
            echo "<h1>Not Found</h1>";
            return ;
        }

    }
    public function run(array $request){
        foreach ($this->modules as $module){
            $this->getContainer()->get($module);
        }
        return $this->handle($request); 
       
    }

    public function getModules() {
        return $this->modules;
        
    }
}