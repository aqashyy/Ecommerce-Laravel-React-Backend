<?php

namespace App\DTO;

class ProductImageDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $image,
        public readonly int $productId
    )
    {
        //
    }
    public static function fromArray(array $data): self
    {
        return new self(
            image: $data['image'],
            productId: $data['product_id']
        );
    }
    public function toArray(): array
    {
        return [
            'image' => $this->image,
            'product_id' => $this->productId
        ];
    }
}
