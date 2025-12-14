<?php namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\framework\Renderer;

class ShopController {
    private $renderer;
    public function __construct(Renderer $renderer) {
        $this->renderer = $renderer;
    }
    
    public function __invoke()
    {
        
        return $this->index();
    }
    public function index(){
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
    public function view($slug, $id) {
        return null;
        
    }
}