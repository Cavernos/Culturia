<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class UpdateArtworkTable extends Migrator
{


    protected $tableName = "artwork";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run()
    {
        $table = $this->table()
            ->addColumn("artist_id", "INT", ["NULL" => "true"])
            ->addForeignKey("artist_id", "artists", "id", ["DELETE" => "CASCADE"])
            ->update()->save();
    }


}
