<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryInterface
{
    public function all(): Collection
    {
        return Category::orderBy('created_at','DESC')->get();
    }
    public function active(): Collection|null
    {
        return Category::orderBy('name','DESC')
                        ->where('status',1)
                        ->get();
    }
    public function find(int $id): ?Category
    {
        return Category::find($id);
    }
    public function create(CategoryDTO $categoryDTO): Category
    {
        return Category::create($categoryDTO->toArray());
    }
    public function update(Category $category, CategoryDTO $categoryDTO): Category
    {
        $category->update($categoryDTO->toArray());
        return $category;
    }
    public function delete(Category $category): void
    {
        $category->delete();
    }
}
