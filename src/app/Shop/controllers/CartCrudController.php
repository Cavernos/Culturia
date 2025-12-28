<?php

namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Paginator;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\SessionInterface;

class CartCrudController extends CrudController
{

    private SessionInterface $session;
    private Renderer $renderer;

    protected string $viewPath = "@shop/cart";

    protected string $routePrefix = "shop.cart";


    public function __construct(Renderer $renderer,
                                ArtworkTable $table,
                                Router $router,
                                SessionInterface $session){
        parent::__construct($renderer, $table, $router);
        $this->session = $session;
        $this->renderer = $renderer;
    }

    public function index(): string
    {
        $user = $this->session->get("auth.user");
        if(isset($this->session->get("carts", [])[$user])){
            $items = $this->session->get("carts", [])[$user];
        } else {
            $items = [];
        }
        $total_price = 0;
        foreach ($items as $item){
            $total_price += $item->price;
        }
        return $this->renderer->render("$this->viewPath/index", compact("items", "total_price"));
    }

    public function edit($id): string
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $item = $this->table->find($id);
            $cart_session = $this->session->get("carts", []);
            $user = $this->session->get("auth.user");
            if(!is_null($user)){
                if(!in_array($item, $cart_session[$user])){

                    $cart_session[$user][] = $item;
                    $this->session->set("carts", $cart_session);
                }
            }
            $this->redirect("shop.view",
                ["slug" => str_replace(" ", "-", strtolower($item->name)), "id" => $item->id ]);
        }
        return $this->index();
    }

    public function delete($id): string
    {
        $cart = $this->session->get("carts", []);
        foreach ($cart as $item){
            if ($item->id == $id){
                $key = array_search($item, $cart);

                unset($cart[$key]);
            }
        }
        $this->session->set("carts", $cart);
        $this->redirect("$this->routePrefix.index");
        return $this->index();
    }

}