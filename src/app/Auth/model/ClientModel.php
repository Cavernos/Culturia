<?php

namespace G1c\Culturia\app\Auth\model;

use G1c\Culturia\framework\Auth\User as AuthUser;


class ClientModel implements AuthUser
{

    public $id;
    public $username;

    public $password;

    public $email;

    public $avatar;

    public $inscriptionDate;

    public $modificationDate;

    public function getUsername():string {
        return $this->username;
    }

    public function getThumb(){
        if($this->avatar){
            ['filename' => $filename, 'extension' => $extension] = pathinfo($this->avatar);
            return "/upload/avatar/{$filename}_thumb.$extension";
        }
        return null;

    }

    public function getImageURL():string {
        return "/upload/avatar/{$this->avatar}";
    }

}