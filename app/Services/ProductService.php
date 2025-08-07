<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\DTO\ProductImageDTO;
use App\DTO\ProductSizeDTO;
use App\DTO\TempImageDTO;
use App\Interfaces\ProductImageInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductSizeInterface;
use App\Interfaces\TempImageInterface;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductService
{
    /**
     *
     * Create a new class instance.
     *
     */
    public function __construct(
        protected ProductInterface $productInterface,
        protected ProductImageInterface $productImageInterface,
        protected ProductSizeInterface $productSizeInterface,
        protected TempImageInterface $tempImageInterface
    ) {}

    /**
     * Product list
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->productInterface->all();
    }
    /**
     *
     * Find a product by its ID
     *
     */

    public function find(int $id): ?Product
    {
        return $this->productInterface->find($id);
    }
    /**
     *
     * Create a new product
     *
     */
    public function create(ProductDTO $productDTO): void
    {
        $product = $this->productInterface->create($productDTO);

        // Handle images and sizes after the product is created
        if (!empty($productDTO->sizes)) {
            $this->handleSizes($product, $productDTO->sizes);
        }
        if (!empty($productDTO->gallery)) {
            $this->handleImages($product, $productDTO->gallery);
        }
    }
    public function update(int $id, ProductDTO $productDTO): ?Product
    {
        $product = $this->productInterface->find($id);
        if (!$product) return null;
        // Update product details
        $updatedProduct = $this->productInterface->update($product, $productDTO);

        // Handle sizes
        if (!empty($productDTO->sizes)) {
            $this->handleSizes($updatedProduct, $productDTO->sizes);
        }
        return $updatedProduct;
    }
    /**
     *
     * Delete a product
     *
     */
    public function delete(int $id): bool
    {
        $product = $this->productInterface->find($id);

        if (!$product) return false;

        $this->productInterface->delete($product);

        return true;
    }
    /**
     *
     * set product default image
     *
     */
    public function setDefaultImage(int $id, string $imageName): bool
    {
        $product    =   $this->productInterface->find($id);

        if(!$product) return false;

        return $this->productInterface->setDefaultImage($product, $imageName);
    }
    /**
     *
     * handle product sizes
     *
     */
    private function handleSizes(Product $product, array $sizes): void
    {
        // Delete existing sizes for the product
        $this->productSizeInterface->delete($product->id);
        // Create new sizes
        foreach ($sizes as $sizeId) {
            $this->productSizeInterface->create(ProductSizeDTO::fromArray([
                'product_id' => $product->id,
                'size_id' => $sizeId
            ]));
        }
    }
    /**
     *
     * handle product Images
     *
     */
    private function handleImages(Product $product, array $gallery): void
    {

        foreach ($gallery as $key =>  $tempImageId) {
            // Find the tempImage image
            $tempImage  =   $this->tempImageInterface->find($tempImageId);

            // Large thumbnail
            $extArray   =   explode('.', $tempImage->name);
            $ext        =   end($extArray);

            $imageName  =   $product->id . '-' . rand(1000, 10000) . time() . '.' . $ext;
            $imagePath  =   public_path('uploads/temp/' . $tempImage->name);
            // Move the image to the product images directory
            $this->saveProductImage($product, $imagePath, $imageName);

            if ($key == 0) {
                // Set the first image as the default image
                $this->productInterface->setDefaultImage($product, $imageName);
            }
        }
    }
    /**
     *
     * Save product images
     *
     */
    public function saveProductImage(Product $product, string $imagePath, string $imageName): ProductImage
    {
            $manager = new ImageManager(Driver::class);
            $img        =   $manager->read($imagePath);
            $img->scaleDown(1200);
            $img->save(public_path('uploads/products/large/' . $imageName));

            // Small Thumbnail
            $manager = new ImageManager(Driver::class);
            $img        =   $manager->read($imagePath);
            $img->coverDown(400, 460);
            $img->save(public_path('uploads/products/small/' . $imageName));

            return $this->productImageInterface->create(ProductImageDTO::fromArray([
                'image' => $imageName,
                'product_id' => $product->id
            ]));
    }

    /**
     *
     * Delete ProductImageById
     *
     */
    public function deleteProductImageById(int $id): bool
    {
        $productImage   =   $this->productImageInterface->find($id);
        if(!$productImage)  return false;

        $this->productImageInterface->delete($productImage);
        return true;
    }

    /**
     *
     * Save TempImage
     *
     */
    public function saveTempImage(UploadedFile $image): TempImage
    {
        $imageName  =   time().'.'.$image->extension();
        $image->move(public_path('uploads/temp'),$imageName);

        // Save Image thumbnail
        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/temp/'.$imageName));
        $img->coverDown(400, 450);
        $img->save(public_path('uploads/temp/thumb/'.$imageName));

        return $this->tempImageInterface->create(TempImageDTO::fromArray(['name' => $imageName]));
    }

    /**
     * 
     * Delete tempimage by id
     *
     */
    public function deleteTempImageById(int $id): bool
    {
        $tempImage  =   $this->tempImageInterface->find($id);
        if(!$tempImage) return false;

        $this->tempImageInterface->delete($tempImage);
        return true;
    }
}
