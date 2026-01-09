<?php

namespace G1c\Culturia\app\Admin;

use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Module;

class AdminModule extends Module
{
    public const DEFINITIONS = __DIR__ . "/config.php";
    public function __construct(Container $c)
    {

    }

}