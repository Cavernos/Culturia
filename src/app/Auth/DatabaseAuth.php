<?php

namespace G1c\Culturia\app\Auth;

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

    public function logout(): void
    {
        $this->session->delete('auth.user');
    }
}