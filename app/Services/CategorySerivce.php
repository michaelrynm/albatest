<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategorySerivce
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Category::query()->latest()->paginate($perPage);
    }

    public function store(array $data): Category
    {
        return Category::create($data);
    }

    public function update (Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
