<?php

namespace G1c\Culturia\app\Shop\table;

use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\app\Shop\model\CategoryModel;
use G1c\Culturia\framework\Database\Query;
use G1c\Culturia\framework\Database\Table;

class CategoryTable extends Table
{
    protected $table = "category";
    protected $entity = CategoryModel::class;
}