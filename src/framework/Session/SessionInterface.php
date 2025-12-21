<?php

namespace G1c\Culturia\framework\Session;

interface SessionInterface
{
    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}