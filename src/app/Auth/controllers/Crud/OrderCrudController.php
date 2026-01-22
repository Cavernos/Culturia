<?php

namespace G1c\Culturia\app\Auth\controllers\Crud;


use DateTime;
use G1c\Culturia\app\Shop\ArtworkUpload;
use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\app\Shop\model\OrderModel;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\OrderTable;
use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Model;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use G1c\Culturia\framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OrderCrudController extends CrudController
{
    protected array $flashMessages = [
        "create" => "La commande a bien été créée",
        "edit" => "La commande a bien été modifiée",
        "delete" => "La commande a bien été supprimée"
    ];

    protected string $routePrefix = "clients.orders";
    private Auth $auth;

    protected string $viewPath = "@shop/";
    private SessionInterface $session;
    private ArtworkTable $artworkTable;

    public function __construct(
        Renderer $renderer,
        OrderTable $orderTable,
        ArtworkTable $artworkTable,
        SessionInterface $session,
        Router $router,
        Auth $auth
    ) {
        parent::__construct($renderer, $orderTable, new FlashService($session), $router);

        $this->auth = $auth;
        $this->session = $session;
        $this->artworkTable = $artworkTable;
    }

    public function delete($id): string|ResponseInterface
    {
        $order = $this->table->findById($id);
        return parent::delete($order);
    }

    public function create(ServerRequestInterface $request): string|ResponseInterface
    {
        $redirection = parent::create($request);
        $user = $this->auth->getUser();
        $order = $this->table->getPdo()->lastInsertId();
        $carts = $this->session->get("carts", []);
        if(isset($carts[$user->id])) {
            $artworks = [];
            foreach ($carts[$user->id] as $artwork) {
                $artworks[] = $this->artworkTable->findById($artwork->id);
            }
            foreach ($artworks as $artwork) {
               $this->artworkTable->update($artwork->id, ["order_id" => $order]);
            }
            unset($carts[$user->id]);
            $this->session->set("carts", $carts);
        }

        return $redirection;
    }
    protected function getParams(ServerRequestInterface $request, $item): array
    {
        $params = array_merge($request->getParsedBody(), $request->getUploadedFiles());
        $params = array_filter($params, function ($key) {
            return $key == "client_id";
        }, ARRAY_FILTER_USE_KEY);
        array_walk_recursive($params, function (&$value) {
            $value = preg_replace('/[^\P{C}]/u', '', $value);
        });
        $params["previsionnal_delivery"] = date("Y-m-d H:i:s");
        $params["client_id"] = $this->auth->getUser()->id;
        $params["client_address"] = "33 Rue de la cannebière";
        return array_merge($params, ["order_date" => date("Y-m-d H:i:s")]);
    }
    public function getRedirectPath(array|Model|null $item = []): array
    {
        return ["auth.index", ["id" => $this->auth->getUser()->id]];
    }
    protected function getNewEntity(): OrderModel
    {
        $order = new OrderModel();
        $order->orderDate = new DateTime();
        return $order;
    }
}