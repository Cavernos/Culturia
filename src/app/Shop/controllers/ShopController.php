<?php namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\framework\Renderer;

class ShopController {
    private $renderer;
    
    public function __invoke(Renderer $renderer)
    {
        $this->renderer = $renderer;
        return $this->index($_REQUEST);
    }
    public function index($request){
        return $this->renderer->render('@shop/shop', ["cards" => [
            ["name"=> "Tata", "price" => "750€"], 
            ["name"=> "Toto", "price" => "750€"],
            ["name"=> "Tata", "price" => "750€"],
            ["name"=> "Tata", "price" => "750€"],
            ["name"=> "Tata", "price" => "750€"],
            ["name"=> "Tata", "price" => "750€"],
            ["name"=> "Tata", "price" => "750€"] 
            ]]);
    }
}