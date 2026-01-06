<?php

namespace G1c\Culturia\framework;

class Model
{
    public $extras = [];

    public function __set($name, $value): void
    {
        $this->extras[$name] = $value;
    }

    public function __get($name) {
        return $this->extras[$name];
    }
     public function __isset($name)
     {
         return isset($this->extras[$name]);
     }

}