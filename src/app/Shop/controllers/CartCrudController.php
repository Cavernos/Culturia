<?php

namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Controllers\SessionCrudController;
use G1c\Culturia\framework\Paginator;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CartCrudController extends SessionCrudController
{

    protected $sessionKey = "carts";

    protected array $flashMessages = [
        "edit" => "L'article a bien été ajouté au panier",
        "delete" => "L'article a été supprimé du panier",
        "exists" => "L'article est déjà dans votre panier"
    ];
    protected string $viewPath = "@shop/cart";

    protected string $routePrefix = "shop.cart";



}