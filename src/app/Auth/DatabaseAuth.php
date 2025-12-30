<?php

namespace G1c\Culturia\app\Auth;

use G1c\Culturia\app\Auth\model\ClientModel;
use G1c\Culturia\app\Auth\table\ClientTable;
use G1c\Culturia\framework\Auth;
use G1c\Culturia\framework\Auth\User;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Session\SessionInterface;

class DatabaseAuth implements Auth
{
    private ClientTable $clientTable;

    private $user;
    private SessionInterface $session;

    public function __construct(ClientTable $clientTable, SessionInterface $session)
    {

        $this->clientTable = $clientTable;
        $this->session = $session;
    }

    public function getUser(): ?User
    {
        if($this->user) {
            return $this->user;
        }
        $userId = $this->session->get('auth.user');
        if($userId) {
            try {
                $this->user = $this->clientTable->find($userId);
                return $this->user;
            } catch (NoRecordException $e) {
                $this->session->delete('auth.user');
                return null;
            }
        }
        return null;
    }

    public function login(string $username, string $password): ?User
    {
        if(empty($username) || empty($password)) {
            return null;
        }
        $user = $this->clientTable->makeQuery()
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
            /** @var ClientModel $user */
            $this->clientTable->insert($params);
            $id = $this->clientTable->getPdo()->lastInsertId();
            $user = $this->clientTable->find($id);
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
}