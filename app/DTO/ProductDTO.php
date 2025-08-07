<?php

namespace App\DTO;

class ProductDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $title,
        public readonly float $price,
        public readonly ?float $compare_price,
        public readonly int $category_id,
        public readonly int $brand_id,
        public readonly string $sku,
        public readonly ?string $barcode,
        public readonly ?int $qty,
        public readonly ?string $description,
        public readonly ?string $short_description,
        public readonly ?string $image,
        public readonly int $status,
        public readonly ?string $is_featured,
        public readonly ?array $gallery = [],
        public readonly ?array $sizes = []

    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            title:             $data['title'],
            price:             $data['price'],
            compare_price:     $data['compare_price'] ?? null,
            category_id:       $data['category_id'],
            brand_id:          $data['brand_id'],
            sku:               $data['sku'],
            barcode:           $data['barcode'] ?? null,
            qty:               $data['qty'] ?? null,
            description:       $data['description'] ?? null,
            short_description: $data['short_description'] ?? null,
            image:             $data['image'] ?? null,
            status:            $data['status'] ?? 1,
            is_featured:       $data['is_featured'] ?? 'no',
            gallery:           $data['gallery'] ?? [],
            sizes:             $data['sizes'] ?? []
        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
