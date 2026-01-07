<?php

namespace G1c\Culturia\framework\Session;

use ArrayAccess;

class PHPSession implements ArrayAccess, SessionInterface
{
    private function ensureStarted(): void
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->delete($offset);
    }

    public function set(string $key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureStarted();
        if ($this->has($key)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function has(string $key): bool
    {
        $this->ensureStarted();
       return array_key_exists($key, $_SESSION);
    }

    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

}