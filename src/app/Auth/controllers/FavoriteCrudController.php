<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\framework\Controllers\SessionCrudController;
use G1c\Culturia\framework\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FavoriteCrudController extends SessionCrudController
{
    protected $sessionKey = "favorite";

    protected array $flashMessages = [
        "edit" => "L'oeuvre a bien été ajoutée au favoris",
        "exists" => "L'oeuvre est déjà dans vos favoris",
        "delete" => "L'oeuvre a bien été supprimé de vos favoris"
    ];

    protected string $viewPath = "@auth/profile";
    protected string $routePrefix = "client.favorite";

    public function index(ServerRequestInterface $request): ResponseInterface|string
    {
        $user = $this->session->get("auth.user");
        return $this->redirect("auth.index", ["id" => $user]);
    }
}