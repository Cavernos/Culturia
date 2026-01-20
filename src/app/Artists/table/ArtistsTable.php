<?php

namespace G1c\Culturia\app\Artists\table;

use G1c\Culturia\app\Artists\model\ArtistsModel;
use G1c\Culturia\framework\Database\Table;

class ArtistsTable extends Table
{
    protected $table = 'artists';

    protected $entity = ArtistsModel::class;


}