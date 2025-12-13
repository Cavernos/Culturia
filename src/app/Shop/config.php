<?php

use G1c\Culturia\app\Shop\ShopModule;
use G1c\Culturia\framework\Container;

return [
    'shop.prefix' => '/shop',
     ShopModule::class => function (){return Container::getInstance()->resolve(ShopModule::class, "shop.prefix");}

];