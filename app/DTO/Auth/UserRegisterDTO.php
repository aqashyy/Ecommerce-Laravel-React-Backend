<?php

namespace App\DTO\Auth;

class UserRegisterDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $role   =   'customer',
        public readonly string $password,
    )
    {
        //
    }

    public static function fromArray(array $data): self
    {

        return new self(
            name: $data['name'],
            email: $data['email'],
            role: 'customer',
            password: $data['password']
        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
