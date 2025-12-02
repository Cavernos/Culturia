<?php namespace G1c\Culturia\app\Home;
use G1c\Culturia\framework\ModuleInterface;
use G1c\Culturia\framework\Router;

class HomeModule implements ModuleInterface {
    const DEFINITIONS = "shop";

    public function launch(){
        $router = new Router();
        return  $router->get($this::DEFINITIONS);;
    }

}