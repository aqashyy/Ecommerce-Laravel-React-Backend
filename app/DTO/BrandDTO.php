<?php

namespace App\DTO;

class BrandDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $status = '1'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:   $data['name'],
            status: $data['status'] ?? '1'
        );
    }
    public function toArray(): array
    {
        return [
            'name'          => $this->name,
            'status'        => $this->status,
        ];
    }
}
