<?php

namespace App\Interfaces;

use App\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryInterface
{
    /**
     * Get all records
     */
    public function all(): Collection;
    /**
     * get record with id
     */
    public function find(int $id): ?Category;
    /**
     * create new record
     */
    public function create(CategoryDTO $categoryDTO): Category;
    /**
     * update record
     */
    public function update(Category $category, CategoryDTO $categoryDTO): Category;
    /**
     * delete record
     */
    public function delete(Category $category): void;

    public function active(): ?Collection;
}
