<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class CreateCategoryTable extends Migrator
{


    protected $tableName = "category";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run()
    {
        $table = $this->table()
            ->addColumn("name", "VARCHAR(128)")
            ->addColumn("description", "VARCHAR(256)")
            ->addColumn("avatar", "VARCHAR(256)")
            ->create();

    }


}
