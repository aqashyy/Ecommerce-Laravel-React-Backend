<?php

namespace App\DTO\Auth;

class UserUpdateDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly int $mobile,
        public readonly string $address,
        public readonly string $state,
        public readonly string $city,
        public readonly string $zip,
    )
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            mobile: $data['mobile'],
            address: $data['address'],
            state: $data['state'],
            city: $data['city'],
            zip: $data['zip']
        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
