<?php

namespace App\Dto\Api\v1\Auth;

class RegisterData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $confirm_password,
    ) {
    }
}
