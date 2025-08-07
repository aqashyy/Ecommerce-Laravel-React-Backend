<?php

namespace App\Interfaces;

use App\DTO\ProductDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductInterface
{
    /**
     * Get all products
     */
    public function all(): Collection;
    /**
     * Find a product by its ID
     */
    public function find(int $id): ?Product;
    /**
     * Create a new product
     */
    public function create(ProductDTO $productDTO): Product;
    /**
     * Update an existing product
     */
    public function update(Product $product, ProductDTO $productDTO): Product;
    /**
     * Delete a product
     */
    public function delete(Product $product): void;
    /**
     * Set default image with product ID
     */
    public function setDefaultImage(Product $product, string $imageName): bool;

}
