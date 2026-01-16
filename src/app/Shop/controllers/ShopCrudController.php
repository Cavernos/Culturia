<?php

namespace G1c\Culturia\app\Shop\controllers;

use DateTime;
use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Controllers\CrudController;
use G1c\Culturia\framework\Model;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Validator;

class ShopCrudController extends CrudController
{
    protected array $flashMessages = [
        "create" => "L'oeuvre a bien été créée",
        "edit" => "L'oeuvre a bien été modifiée",
        "delete" => "L'oeuvre a bien été supprimée"
    ];

    protected string $viewPath = "@shop/admin/artwork";

    protected string $routePrefix = "admin.artworks";

    private ArtistsTable $artistsTable;

    public function __construct(
        Renderer $renderer,
        ArtworkTable $artworkTable,
        ArtistsTable $artistsTable,
        FlashService $flashService,
        Router $router
    ) {
        parent::__construct($renderer, $artworkTable, $flashService, $router);

        $this->artistsTable = $artistsTable;
    }

    public function delete($id): string
    {
        $artwork = $this->table->findById($id);
        return parent::delete($artwork->id);
    }

    protected function getParams($item): array
    {
        $params = array_merge($_POST, $_FILES);
        $params["image"] = "/assets/img/oeuvre_1.png";

        $params = array_filter($params, function ($key) {
            return in_array($key, ['name', "creation_date", "description", "artist_id", "image", "price"]);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, ["modification_date" => date("Y-m-d H:i:s")]);
    }

    public function getValidator($request): Validator
    {
        $validator = parent::getValidator($request)
            ->required('name', 'creation_date', "description", 'artist_id', "price")
            ->length("name", 3, 100)
            ->length("description", 5, 200)
            ->exists("artist_id", $this->artistsTable->getTable(), $this->artistsTable->getPdo())
            ->extension("image", ["jpg", "png"])
            ->dateTime("creation_date");
        return $validator;
    }

    protected function getNewEntity(): ArtworkModel
    {
        $artwork = new ArtworkModel();
        $artwork->creationDate = new DateTime();
        $artwork->modificationDate = new DateTime();
        return $artwork;
    }

    protected function formParams(array $params): array
    {
        $params["artists"] = $this->artistsTable->findList();
        return $params;
    }

    protected function getRedirectPath(array $item): array
    {
        return ["artists.profile", ["id" => $item["artist_id"]]];
    }
}