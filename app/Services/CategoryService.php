<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected CategoryInterface $categoryInterface)
    {
        //
    }

    /**
     * category list
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->categoryInterface->all();
    }
    public function find(int $id): ?Category
    {
        return $this->categoryInterface->find($id);
    }
    /**
     * Summary of create
     * @param \App\DTO\CategoryDTO $categoryDTO
     * @return Category
     */
    public function create(CategoryDTO $categoryDTO): Category
    {
        return $this->categoryInterface->create($categoryDTO);
    }
    /**
     * Summary of update
     * @param int $id
     * @param \App\DTO\CategoryDTO $categoryDTO
     * @return Category|null
     */
    public function update(int $id, CategoryDTO $categoryDTO): ?Category
    {
        $category   =   $this->categoryInterface->find($id);
        if(!$category) return null;
        return $this->categoryInterface->update($category, $categoryDTO);
    }
    /**
     * Summary of delete
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $category   =   $this->categoryInterface->find($id);

        if(!$category) return false;

        $this->categoryInterface->delete($category);

        return true;
    }
}
