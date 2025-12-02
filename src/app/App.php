<?php namespace G1c\Culturia\app;
use G1c\Culturia\framework\ModuleInterface;
class App {

    /**
     * @var array
     */
    private $modules = [];
    public function __construct(){


    }
    public function add(ModuleInterface $module) {
        array_push($this->modules, $module);
        return $this;
    }
    public function run(){
        foreach ($this->modules as $module){
            $module->launch();
        }
    }
}