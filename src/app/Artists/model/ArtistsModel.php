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

    public function getThumb(){
        if($this->avatar){
            ['filename' => $filename, 'extension' => $extension] = pathinfo($this->avatar);
            return "/upload/artists/avatar/{$filename}_thumb.$extension";
        }
        return null;

    }

    public function getImageURL(): string {
        return "/upload/artists/avatar/{$this->avatar}";
    }

    public function is(string $model): bool
    {
        return $this instanceof $model;
    }
}