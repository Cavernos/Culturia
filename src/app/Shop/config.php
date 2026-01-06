<?php

use G1c\Culturia\app\Shop\CartRendererExtension;
use G1c\Culturia\app\Shop\ShopModule;
use G1c\Culturia\framework\Container;

return [
    'shop.prefix' => '/shop',
     ShopModule::class => function (Container $c){return new ShopModule($c);},
    'renderer.extensions' => [
        CartRendererExtension::class
    ]

];