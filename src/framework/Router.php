<?php namespace G1c\Culturia\framework;

class Router {
    public function get($route){
        $config = require('config/config.php');
        header("Location: " . $config['view.path'] . DIRECTORY_SEPARATOR. $route . ".html", true, 200);
        exit();

    }
    
}