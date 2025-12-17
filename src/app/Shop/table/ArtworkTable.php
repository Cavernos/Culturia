<?php

namespace G1c\Culturia\app\Shop\table;

use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\framework\Database\Table;

class ArtworkTable extends Table
{
    protected $table = "artwork";
    protected $entity = ArtworkModel::class;

    public function findPublic()
    {
        return $this->makeQuery()
            ->select("artwork.*", "artists.username")
            ->join("artists", "artists.id = artist_id");
    }
}