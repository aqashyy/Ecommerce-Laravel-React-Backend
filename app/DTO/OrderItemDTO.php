<?php

namespace App\DTO;

readonly class OrderItemDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $productId,
        public int $orderId,
        public string $name,
        public string $size,
        public float $price,
        public float $unitPrice,
        public int $qty
    )
    {
        //
    }

    public static function fromArray($data): self
    {
        return new self(
            productId: $data['product_id'],
            orderId: $data['order_id'],
            name: $data['name'],
            size: $data['size'],
            price: $data['price'],
            unitPrice: $data['unit_price'],
            qty: $data['qty']
        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
