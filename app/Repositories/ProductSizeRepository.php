<?php

namespace App\Repositories;

use App\DTO\ProductSizeDTO;
use App\Interfaces\ProductSizeInterface;
use App\Models\ProductSize;

class ProductSizeRepository implements ProductSizeInterface
{
    public function create(ProductSizeDTO $productSizeDTO): ProductSize
    {
        return ProductSize::create($productSizeDTO->toArray());
    }
    public function delete(int $productId): void
    {
        ProductSize::where('product_id', $productId)->delete();
    }
}
