<?php

namespace App\DTO;

class ProductSizeDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $productId,
        public readonly int $sizeId,
    )
    {
        //
    }
    public static function fromArray(array $data): self
    {
        return new self(
            productId: $data['product_id'],
            sizeId: $data['size_id']
        );
    }
    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'size_id' => $this->sizeId
        ];
    }
}
