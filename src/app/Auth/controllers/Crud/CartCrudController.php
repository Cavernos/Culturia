<?php

namespace G1c\Culturia\app\Auth\controllers\Crud;

use G1c\Culturia\framework\Controllers\SessionCrudController;

class CartCrudController extends SessionCrudController
{

    protected $sessionKey = "carts";

    protected array $flashMessages = [
        "edit" => "L'article a bien été ajouté au panier",
        "delete" => "L'article a été supprimé du panier",
        "exists" => "L'article est déjà dans votre panier"
    ];
    protected string $viewPath = "@shop/cart";

    protected string $routePrefix = "client.cart";



}