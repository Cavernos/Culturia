<?php

namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Paginator;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

        $this->session = $session;
        $this->renderer = $renderer;
        parent::__construct($renderer, $table, new FlashService($session), $router);
    }

    public function index(ServerRequestInterface $request): string
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

    public function edit(ServerRequestInterface $request): string
    {
        if($request->getMethod() == "POST"){
            $item = $this->table->findById($request->getAttribute("id"));
            $cart_session = $this->session->get("carts", []);
            $user = $this->session->get("auth.user");
            if(!is_null($user)){

                if(!isset($cart_session[$user][$item->id])){
                    $cart_session[$user][$item->id] = $item;
                    (new FlashService($this->session))->success("L'article a bien été ajouté au panier");
                    $this->session->set("carts", $cart_session);
                } else {
                    (new FlashService($this->session))->error("L'article est déjà dans votre panier");
                }
            }

            $this->redirect("shop.view",
                ["slug" => str_replace(" ", "-", strtolower($item->name)), "id" => $item->id ]);
        }
        return $this->index($request);
    }

    public function delete($id): ResponseInterface
    {
        $user = $this->session->get("auth.user");
        $cart = $this->session->get("carts", []);
        if(isset($cart[$user])){
            foreach ($cart[$user] as $item){
                if ($item->id == $id){
                    $key = array_search($item, $cart[$user]);

                    unset($cart[$user][$key]);
                }
            }
        }
        $this->session->set("carts", $cart);
        (new FlashService($this->session))->success("L'article a bien été supprimé du panier");
        return $this->redirect("$this->routePrefix.index");
    }

}