<?php

namespace App\Interfaces;

use App\DTO\ProductImageDTO;
use App\Models\ProductImage;

interface ProductImageInterface
{
    public function find(int $id): ?ProductImage;
    public function create(ProductImageDTO $productImageDTO): ProductImage;
    public function delete(ProductImage $productImage): void;
}
