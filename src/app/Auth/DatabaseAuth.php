<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\app\Artists\model\ArtistsModel;
use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\app\Auth\table\ClientTable;
use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Auth\User;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Database\Table;
use G1c\Culturia\framework\Session\SessionInterface;

class DatabaseAuth implements Auth
{
    private ClientTable $clientTable;

    private $user;
    private SessionInterface $session;
    private ArtistsTable $artistsTable;

    public function __construct(ClientTable $clientTable, ArtistsTable $artistsTable,  SessionInterface $session)
    {

        $this->clientTable = $clientTable;
        $this->session = $session;
        $this->artistsTable = $artistsTable;
    }

    public function getUser(): ?User
    {
        if($this->user) {
            return $this->user;
        }
        $userId = $this->session->get('auth.user');
        $role = $this->session->get('auth.role');
        if($userId) {
            $table = $this->getTable($role);
            try {
                $this->user = $table->findById($userId);
            } catch (NoRecordException $e) {
                return null;
            }
            if(!is_null($this->user)) {
                return $this->user;
            }
            $this->session->delete('auth.user');
            $this->session->delete('auth.role');
        }
        return null;
    }

    public function login(string $username, string $password, string $role): ?User
    {
        if(empty($username) || empty($password)) {
            return null;
        }
        $table = $this->getTable($role);
        $user  = $table->findByParams("email = :email OR username = :email",[':email' => $username] );
        if($user && password_verify($password, $user->password)) {
            $this->session->set('auth.user', $user->id);
            $this->session->set('auth.role', (bool)$role);
            return $user;
        }
        return null;
    }

    public function register(array $params): ?User
    {
        if(!array_key_exists('email', $params)
            ||!array_key_exists('password', $params)
            ||!array_key_exists('password2', $params)
            ||!array_key_exists('username', $params)
            || !array_key_exists('role', $params)

        ) {
            return null;
        }
        $role = (bool)$params['role'];
        if($params["password"] === $params["password2"]){
            $params = ["username" => $params["username"],
                "email" => $params["email"],
                "password" => password_hash($params["password"], PASSWORD_BCRYPT),
                "avatar" => "/assets/img/artist_1.png",
                "inscription_date" => date("Y-m-d H:i:s"),
                "modification_date" => date("Y-m-d H:i:s")

            ];
            $table = $this->getTable($role);
            $table->insert($params);
            $id = $table->getPdo()->lastInsertId();
            $user = $table->findById($id);
            if($user){
                $this->session->set('auth.user', $user->id);
                $this->session->set('auth.role', $role);
                return $user;
            }
        }
        return null;

    }

    public function logout(): void
    {
        $this->session->delete('auth.user');
        $this->session->delete('auth.role');
    }

    public function getTable(bool $role): Table
    {
        if($role) {
            return $this->clientTable;
        } else {
            return $this->artistsTable;
        }

    }
}