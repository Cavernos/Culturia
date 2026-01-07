<?php

use G1c\Culturia\app\Artists\ArtistsModule;
use G1c\Culturia\framework\Container;

return [
    "artists.prefix" => "/artists",
    "artists.profile.prefix" => "/artists/profile",
    ArtistsModule::class => function (Container $c) {
        return new ArtistsModule($c);
    }
];