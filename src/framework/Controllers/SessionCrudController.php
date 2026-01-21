<?php

namespace G1c\Culturia\framework\Controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SessionCrudController extends CrudController
{
    protected $sessionKey = "";

    protected array $flashMessages = [
        "edit" => "L'item a bien été ajouté",
        "delete" => "L'item a bien été supprimé",
        "exists" => "L'item est déjà dans votre panier",
    ];

    protected SessionInterface $session;
    private Renderer $renderer;


    public function __construct(Renderer         $renderer,
                                ArtworkTable     $table,
                                Router           $router,
                                SessionInterface $session)
    {

        $this->session = $session;
        $this->renderer = $renderer;
        parent::__construct($renderer, $table, new FlashService($session), $router);
    }

    public function index(ServerRequestInterface $request): string|ResponseInterface
    {
        $user = $this->session->get("auth.user");
        if (isset($this->session->get($this->sessionKey, [])[$user])) {
            $items = $this->session->get($this->sessionKey, [])[$user];
        } else {
            $items = [];
        }
        return $this->renderer->render("$this->viewPath/index", compact("items"));
    }

    public function edit(ServerRequestInterface $request): string|ResponseInterface
    {
        if ($request->getMethod() == "POST") {
            $item = $this->table->findById($request->getAttribute("id"));
            $cart_session = $this->session->get($this->sessionKey, []);
            $user = $this->session->get("auth.user");
            if (!is_null($user)) {
                if (!isset($cart_session[$user][$item->id])) {
                    $cart_session[$user][$item->id] = $item;
                    (new FlashService($this->session))->success($this->flashMessages["edit"]);
                    $this->session->set($this->sessionKey, $cart_session);
                } else {
                    (new FlashService($this->session))->error($this->flashMessages["exists"]);
                }
            }

            return $this->redirect("shop.view",
                ["slug" => str_replace(" ", "-", strtolower($item->name)), "id" => $item->id]);
        }
        return $this->index($request);
    }

    public function delete($id): ResponseInterface
    {
        $user = $this->session->get("auth.user");
        $cart = $this->session->get($this->sessionKey, []);
        if (isset($cart[$user])) {
            foreach ($cart[$user] as $item) {
                if ($item->id == $id) {
                    $key = array_search($item, $cart[$user]);

                    unset($cart[$user][$key]);
                }
            }
        }
        $this->session->set($this->sessionKey, $cart);
        (new FlashService($this->session))->success($this->flashMessages["delete"]);
        return $this->redirect("$this->routePrefix.index");
    }
}