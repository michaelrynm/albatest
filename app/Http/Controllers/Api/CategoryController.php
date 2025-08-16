<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategorySerivce;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategorySerivce $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $data = $this->service->paginate($perPage);
        return CategoryResource::collection($data)
            ->additional(['meta' => ['per_page' => $perPage]]);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->store($request->validated());
        return response()->json(new CategoryResource($category), 201);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category = $this->service->update($category, $request->validated());
        return response()->json(new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->service->delete($category);
        return response()->json(['message' => 'Category deleted']);
    }
}
