<?php

namespace G1c\Culturia\app\Shop\table;

use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\framework\Database\Query;
use G1c\Culturia\framework\Database\Table;

class ArtworkTable extends Table
{
    protected $table = "artwork";
    protected $entity = ArtworkModel::class;

    public function findPublic(): Query
    {
        return $this->makeQuery()
            ->select("artwork.*", "artists.username")
            ->join("artists", "artists.id = artist_id");
    }
    public function findPublicId(int $id)
    {
        $query = clone $this->findPublic()->select("artwork.*", "artists.username", "artists.avatar");
        return $query->where("$this->table.id = $id");

    }

    public function findRecent()
    {
        $query = clone $this->findPublic();
        return $query->order("modification_date DESC")->limit(16);

    }
}