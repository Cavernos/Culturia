<?php

namespace G1c\Culturia\framework\Middlewares;

use ArrayAccess;
use G1c\Culturia\framework\Exception\CsrfInvalidException;
use TypeError;

class CsrfMiddleware
{
    private $session;
    private int $limit;
    private string $formKey;
    private string $sessionKey;

    public function __construct(&$session, int $limit = 50, string $formKey = "_csrf", string $sessionKey = 'csrf')
    {
        $this->validSession($session);
        $this->session = $session;
        $this->limit = $limit;
        $this->formKey = $formKey;
        $this->sessionKey = $sessionKey;
    }

    public function __invoke($request, callable $next) {
        if(in_array($request["REQUEST_METHOD"], ['POST', 'PUT', 'DELETE'])) {
            $params = $_POST ?: [];
            if(!array_key_exists($this->formKey, $params)) {
                $this->reject();
            } else {
                $csrfList = $this->session[$this->sessionKey] ?? [];
                if(in_array($params[$this->formKey], $csrfList)) {
                    $this->useToken($params[$this->formKey]);
                    return $next($request);
                } else {
                    $this->reject();
                }

            }

        } else {
            return $next($request);
        }
    }

    public function generateToken(): string
    {
        $token = bin2hex(random_bytes(16));
        $csrfList = $this->session[$this->sessionKey] ?? [];
        $csrfList[] = $token;
        $this->session->set($this->sessionKey, $csrfList);
        $this->limitToken();
        return $token;

    }

    /**
     * @throws CsrfInvalidException
     */
    public function reject(): void
    {
        throw new CsrfInvalidException();
    }

    public function useToken(string $token): void
    {
        $tokens = array_filter($this->session[$this->sessionKey], function (string $t) use ($token) {
            return $token !== $t;
        });
        $this->session->set($this->sessionKey, $tokens);
    }
    public function limitToken(): void
    {
        $tokens = $this->session[$this->sessionKey] ?? [];
        if(count($tokens) > $this->limit) {
            array_shift($tokens);
        }
        $this->session->set($this->sessionKey, $tokens);

    }

    public function validSession($session): void
    {
        if(!is_array($session) && !$session instanceof ArrayAccess) {
            throw new TypeError("La session passée au middleware CSRF n'est pas traitable comme un tableau");
        }
    }

    public function getFormKey()
    {
        return $this->formKey;
    }
}