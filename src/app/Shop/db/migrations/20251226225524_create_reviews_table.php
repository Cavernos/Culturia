<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class CreateReviewsTable extends Migrator
{


    protected $tableName = "reviews";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run()
    {
        $this->table()
            ->addColumn("rate", "INTEGER")
            ->addColumn("review_date", "DATE")
            ->addColumn("comment", "VARCHAR(256)")
            ->create();

    }


}
