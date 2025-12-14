<?php namespace G1c\Culturia\app;

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class App {

    
    private $container;
    /**
     * @var array
     */
    private $modules = [];
    private $definition;
    private $renderer;
    private $router;

    public function __construct(string $definition){
        $this->definition = $definition;


    }
    public function getContainer(){
        $container = Container::getInstance($this->definition);
        foreach($this->modules as $module){
            if($module::DEFINITIONS){
                $container->addDefinition($module::DEFINITIONS);
            }    
        }
        $container->get(Renderer::class)->addGlobal("layout_path", $container->get('view.path'). DIRECTORY_SEPARATOR. "layout.php");
        $this->container = $container;
        return $this->container;

    }
    public function add(string $module): self {
        $this->modules[] = $module;
        return $this;
    }
    public function handle(mixed $request){
        $match = Container::getInstance()->get(Router::class)->match($_SERVER["REQUEST_URI"]);
        return $match;     
    }
    public function run(array $request){
        $container = $this->getContainer();
        foreach ($this->modules as $module){
           $module = $container->get($module);
        }
        return $this->handle($request); 
       
    }

    public function getModules() {
        return $this->modules;
        
    }
}