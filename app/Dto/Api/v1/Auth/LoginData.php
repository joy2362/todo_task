<?php

namespace App\Dto\Api\v1\Auth;

class LoginData
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember = false,
    ) {
    }
}
