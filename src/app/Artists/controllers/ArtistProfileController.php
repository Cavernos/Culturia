<?php

namespace G1c\Culturia\app\Artists\controllers;


use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\OrderTable;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Renderer;
use MongoDB\Driver\Server;
use Psr\Http\Message\ServerRequestInterface;

class ArtistProfileController
{
    private Renderer $renderer;
    private ArtistsTable $artistsTable;
    private ArtworkTable $artworkTable;
    private OrderTable $orderTable;

    public function __construct(Renderer $renderer,
                                ArtistsTable $artistsTable,
                                ArtworkTable $artworkTable,
                                OrderTable $orderTable)
    {

        $this->renderer = $renderer;
        $this->artistsTable = $artistsTable;
        $this->artworkTable = $artworkTable;
        $this->orderTable = $orderTable;
    }

    public function __invoke()
    {
    }

    public function profile(ServerRequestInterface $request): string
    {
        $id = $request->getAttribute("id");
        try {
            $user = $this->artistsTable->findById($id);
        } catch (NoRecordException $e) {

        }
        $user_artworks = $this->artworkTable->makeQuery()
            ->select("artwork.*")
            ->join("artists", "artist_id = artists.id")
            ->where("artists.id = :id")
            ->params([":id" => $id])
            ->fetchAll();

        $orders = $this->orderTable->findByArtistsId($id)->fetchAll();
        return $this->renderer->render("@artists/profile/index",
            compact("user", "user_artworks", "orders"));
    }
}