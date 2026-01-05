<?php

namespace G1c\Culturia\app\Artists;

use G1c\Culturia\framework\Module;

class ArtistsModule extends Module
{
    public const DEFINITIONS = __DIR__ . "/config.php";
    public const MIGRATIONS = __DIR__ . "/db/migrations";
    public const SEEDS = __DIR__ . "/db/seeds";
    public function __construct()
    {

    }
}