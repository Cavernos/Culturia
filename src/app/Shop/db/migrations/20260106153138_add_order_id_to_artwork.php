<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class AddOrderIdToArtwork extends Migrator
{


    protected $tableName = "artwork";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run(): void
    {
        $this->table()
            ->addColumn("order_id", "INT", ["NULL" => "true"])
            ->addForeignKey("order_id", "orders", "id", ["DELETE" => "CASCADE"])
            ->update()->save();


    }


}
