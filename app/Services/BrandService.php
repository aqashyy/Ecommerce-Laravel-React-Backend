<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Interfaces\BrandInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected BrandInterface $brandInterface)
    {
        //
    }

    public function list(): Collection
    {
        return $this->brandInterface->all();
    }

    public function find(string $id): ?Brand
    {
        return $this->brandInterface->find($id);
    }
    public function getActive(): Collection|null
    {
        return $this->brandInterface->active();
    }
    public function create(BrandDTO $dto): Brand
    {
        return $this->brandInterface->create($dto);
    }
    public function update(string $id, BrandDTO $dto): ?Brand
    {
        $brand  =   $this->brandInterface->find($id);
        if (!$brand) return null;

        return $this->brandInterface->update($brand,$dto);
    }

    public function delete(string $id): bool
    {
        $brand  =   $this->brandInterface->find($id);
        if (!$brand) return false;

        $this->brandInterface->delete($brand);
        return true;

    }
}
