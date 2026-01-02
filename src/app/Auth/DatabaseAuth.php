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
        if($userId) {
            $this->user = $this->searchUser($this->clientTable, $userId);
            if(!is_null($this->user)) {
                return $this->user;
            }
            $this->user = $this->searchUser($this->artistsTable, $userId);
            if(!is_null($this->user)) {
                return $this->user;
            }
            $this->session->delete('auth.user');
        }
        return null;
    }

    public function login(string $username, string $password, string $role): ?User
    {
        if(empty($username) || empty($password)) {
            return null;
        }
        if($role) {
            $table = $this->clientTable;
        } else {
            $table = $this->artistsTable;
        }
        $user  = $table->makeQuery()
            ->where("email = :email OR username = :email")
            ->params([':email' => $username])
            ->fetchOrFail();
        if($user && password_verify($password, $user->password)) {
            $this->session->set('auth.user', $user->id);
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
        if($params["password"] === $params["password2"]){
            $params = ["username" => $params["username"],
                "email" => $params["email"],
                "password" => password_hash($params["password"], PASSWORD_BCRYPT),
                "avatar" => "/assets/img/artist_1.png",
                "inscription_date" => date("Y-m-d H:i:s"),
                "modification_date" => date("Y-m-d H:i:s")

            ];
            if($params["role"]) {
                /** @var ClientModel $user */
                $table =$this->clientTable;
            } else {
                /** @var ArtistsModel $user */
                $table = $this->artistsTable;
            }
            $table->insert($params);
            $id = $table->getPdo()->lastInsertId();
            $user = $table->find($id);
            if($user){
                $this->session->set('auth.user', $user->id);
                return $user;
            }
        }
        return null;

    }

    public function logout(): void
    {
        $this->session->delete('auth.user');
    }

    private function searchUser(Table $table, int $id): ?User
    {
        try {
            return $table->find($id);
        } catch (NoRecordException $e) {
            return null;
        }

    }
}