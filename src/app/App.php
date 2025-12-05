<?php namespace G1c\Culturia\app;

use G1c\Culturia\app\Shop\ShopModule;
class App {

    /**
     * @var array
     */
    private $modules = [];

    private $definition;
    public function __construct(string $definition){
        $this->definition = $definition;


    }
    public function add(ShopModule $module): self {
        array_push($this->modules, $module);
        return $this;
    }
    public function run(){
        foreach ($this->modules as $module){
            return $module;
        }
    }

    public function getModules() {
        return $this->modules;
        
    }
}