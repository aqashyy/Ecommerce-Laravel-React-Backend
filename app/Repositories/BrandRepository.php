<?php

namespace App\Repositories;

use App\DTO\BrandDTO;
use App\Interfaces\BrandInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository implements BrandInterface
{
    /**
     * Create a new class instance.
     */
    public function all(): Collection
    {
        return Brand::orderBy('created_at','DESC')->get();
    }
    public function find(string $id): ?Brand
    {
        return Brand::find($id);
    }
    public function create(BrandDTO $dto): Brand
    {
        return Brand::create($dto->toArray());
    }
    public function update(Brand $brand, BrandDTO $dto): Brand
    {
        $brand->update($dto->toArray());
        return $brand;
    }
    public function delete(Brand $brand): void
    {
        $brand->delete();
    }
}
