<?php

namespace G1c\Culturia\framework\Session;

class FlashService
{
    private SessionInterface $session;

    private $sessionKey = "flash";

    private $message = null;

    public function __construct(SessionInterface $session)
    {

        $this->session = $session;
    }

    public function success(string $message): void
    {
        $this->add("success", $message);
    }

    public function error(string $message): void
    {
        $this->add("error", $message);
    }

    private function add(string $type, string $message): void
    {
        $this->session->get($this->sessionKey, []);
        $flash[$type] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function get(string $type): ?string
    {
        if(is_null($this->message)){
            $this->message = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
        if (array_key_exists($type, $this->message)){
            return $this->message[$type];
        }
        return null;
    }

}