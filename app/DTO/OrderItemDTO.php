<?php

namespace App\DTO;

readonly class OrderItemDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $product_id,
        public int $order_id,
        public string $name,
        public string $size,
        public float $price,
        public float $unit_price,
        public int $qty
    )
    {
        //
    }

    public static function fromArray($data): self
    {
        return new self(
            product_id: $data['product_id'],
            order_id: $data['order_id'],
            name: $data['name'],
            size: $data['size'],
            price: $data['price'],
            unit_price: $data['unit_price'],
            qty: $data['qty']
        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
