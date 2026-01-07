<?php

namespace G1c\Culturia\framework\Auth;

interface User
{
    public function getUsername(): string;

    public function is(string $model): bool;
}