<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;

class {{className}} extends Migrator
{


    protected $tableName = "{{tableName}}";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }


    public function run()
    {

    }


}
