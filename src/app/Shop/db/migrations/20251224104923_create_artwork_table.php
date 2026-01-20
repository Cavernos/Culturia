<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class ArtworkMigrations extends Migrator
{


    protected $tableName = "artwork";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run()
    {
        $table = $this->table()
            ->addColumn("name", "VARCHAR(128)")
            ->addColumn("description", "VARCHAR(255)")
            ->addColumn("creation_date", "DATE")
            ->addColumn("modification_date", "DATE")
            ->addColumn("price", "INT UNSIGNED")
            ->addColumn("image", "VARCHAR(128)")
            ->create();
    }


}