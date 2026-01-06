<?php

namespace G1c\Culturia\framework\Auth;

use G1c\Culturia\framework\Model;

interface User
{
    public function getUsername(): string;

    public function is(Model $model): bool;
}