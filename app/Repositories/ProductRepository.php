<?php

namespace App\Repositories;

use App\DTO\ProductDTO;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductInterface
{
    /**
     * Get all products
     */
    public function all(): Collection
    {
        return Product::with(['product_images','product_sizes'])->orderBy('created_at', 'DESC')->get();
    }
    /**
     * Find a product by its ID
     */
    public function find(int $id): ?Product
    {
        return Product::with(['product_images','product_sizes'])->find($id);
    }
    /**
     * Create a new product
     */
    public function create(ProductDTO $productDTO): Product
    {
        $product  = new Product($productDTO->toArray());
        $product->save();

        return $product;
    }
    /**
     * Update an existing product
     */
    public function update(Product $product, ProductDTO $productDTO): Product
    {
        $dataArray = $productDTO->toArray();
        foreach($dataArray as $field => $value)
        {
            if(!is_null($value) && $field == 'gallery' && $field == 'sizes')
            {
                $product->$field = $value;
            }
        }
        $product->save();
        return $product;
    }
    /**
     * Delete a product
     */
    public function delete(Product $product): void
    {
        // delete product images also
        if($product->product_images) {
            foreach($product->product_images as $pImage) {
                @unlink(public_path('uploads/products/large/'.$pImage->image));
                @unlink(public_path('uploads/products/small/'.$pImage->image));
            }
        }
        // currently cascade deletion not working, mannually deleting...
        $product->product_images()->delete();
        $product->product_sizes()->delete();
        $product->delete();
    }
    public function setDefaultImage(Product $product, string $imageName): bool
    {
        $product->image = $imageName;
        return $product->save();
    }

    public function getLatest(int $limit): ?Collection
    {
        return Product::orderBy('created_at','DESC')
                        ->where('status',1)
                        ->limit($limit)
                        ->get();
    }
    public function getFeatured(int $limit): ?Collection
    {
        return Product::orderBy('created_at','DESC')
                        ->where('status',1)
                        ->where('is_featured','yes')
                        ->limit($limit)
                        ->get();
    }
}
