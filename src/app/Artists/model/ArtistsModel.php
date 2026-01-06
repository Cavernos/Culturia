<?php

namespace G1c\Culturia\app\Artists\model;

use G1c\Culturia\framework\Auth\User as AuthUser;
use G1c\Culturia\framework\Model;

class ArtistsModel extends Model implements AuthUser
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

    public function is(ArtistsModel|Model $model): bool
    {
        return $this instanceof $model;
    }
}