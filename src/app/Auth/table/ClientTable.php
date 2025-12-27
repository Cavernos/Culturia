<?php

namespace G1c\Culturia\app\Auth\table;

use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\framework\Database\Table;

class ClientTable extends Table
{
    protected $table = 'clients';

    protected $entity = ClientModel::class;
}