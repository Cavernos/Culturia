<?php

namespace G1c\Culturia\framework\Auth;

use Exception;

class ForbiddenException extends Exception
{

    private string $accountType;

    public function __construct(string $accountType, string $message = "Forbidden", int $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->accountType = $accountType;
    }

    public function getAccountType(): string {
        return $this->accountType;
    }
}