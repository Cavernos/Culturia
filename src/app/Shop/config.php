<?php

use G1c\Culturia\app\Shop\ShopModule;

return [
    'prefix' => '/shop',
    ShopModule::class => new ShopModule('/shop', ),
    
];