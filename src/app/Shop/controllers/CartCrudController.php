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
        $items = $this->session->get("carts", []);
        $total_price = 0;
        foreach ($items as $item){
            $total_price += $item->price;
        }
        return $this->renderer->render("$this->viewPath/index", compact("items", "total_price"));
    }


    public function create(): void
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $this->redirect("shop.index");
        }


    }
    public function edit($id): void
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $item = $this->table->find($id);
            $cart_session = $this->session->get("carts", []);
            if(!in_array($item, $cart_session)){
                $cart_session[] = $item;
                $this->session->set("carts", $cart_session);
            }
            $this->redirect("shop.cart.index");
        }
    }

}