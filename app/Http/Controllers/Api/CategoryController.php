<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Interfaces\Services\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully.',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        $category = $this->categoryService->updateCategory($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully.',
            'data' => $category
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->categoryService->deleteCategory($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function parentCategories(): JsonResponse
    {
        $categories = $this->categoryService->getParentCategories();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    public function subCategories($parentId): JsonResponse
    {
        $categories = $this->categoryService->getSubCategories($parentId);
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    public function categoryPosts($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryWithPosts($id);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }
}
