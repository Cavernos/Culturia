<?php

namespace G1c\Culturia\app\Artists\model;

use G1c\Culturia\framework\Auth\User as AuthUser;

class ArtistsModel implements AuthUser
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $avatar;

    public function getUsername(): string
    {
        return $this->username;
    }
}