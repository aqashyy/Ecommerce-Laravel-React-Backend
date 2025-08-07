<?php

namespace App\Repositories;

use App\DTO\ProductImageDTO;
use App\Interfaces\ProductImageInterface;
use App\Models\ProductImage;

class ProductImageRepository implements ProductImageInterface
{
    /**
     * Find product image with id
     *
     */
    public function find(int $id): ProductImage|null
    {
        return ProductImage::find($id);
    }
    /**
     * Create a new class instance.
     *
     */
    public function create(ProductImageDTO $productImageDTO): ProductImage
    {
        return ProductImage::create($productImageDTO->toArray());
    }

    /**
     * Delete product image
     * 
     */
    public function delete(ProductImage $productImage): void
    {
        // delete image from path
        @unlink(public_path('uploads/products/large/'.$productImage->image));
        @unlink(public_path('uploads/products/small/'.$productImage->image));

        $productImage->delete();
    }
}
