<?php

namespace G1c\Culturia\framework;

use G1c\Culturia\framework\Auth\User;

interface Auth
{
    public function getUser(): ?User;
}