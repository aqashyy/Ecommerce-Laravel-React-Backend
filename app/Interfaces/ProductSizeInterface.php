<?php

namespace App\Interfaces;

use App\DTO\ProductSizeDTO;
use App\Models\ProductSize;

interface ProductSizeInterface
{
    /**
     * Create a new product size record.
     */
    public function create(ProductSizeDTO $productSizeDTO): ProductSize;
    /**
     * Delete all sizes for a given product ID.
     */
    public function delete(int $productId): void;
}
