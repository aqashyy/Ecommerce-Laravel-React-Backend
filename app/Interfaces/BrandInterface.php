<?php

namespace App\Interfaces;

use App\DTO\BrandDTO;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

interface BrandInterface
{
    /**
     * to get all records
     */
    public function all(): Collection;

    /**
     * find record with id
     */
    public function find(string $id): ?Brand;
    /**
     * create a new record
     */
    public function create(BrandDTO $dto): Brand;
    /**
     * update record
     */
    public function update(Brand $brand,BrandDTO $dto): Brand;
    /**
     * delete record
     */
    public function delete(Brand $brand): void;
}
