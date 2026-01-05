<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class CreateArtistsTable extends Migrator
{


    protected $tableName = "artists";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run()
    {
        $table = $this->table()
            ->addColumn('username', "VARCHAR(128)")
            ->addColumn('avatar', "VARCHAR(128)")
            ->addColumn('email', "VARCHAR(128)")
            ->addColumn('password', "VARCHAR(128)")
            ->addColumn("inscription_date", "DATE")
            ->addColumn("modification_date", "DATE")
            ->create();
    }


}
