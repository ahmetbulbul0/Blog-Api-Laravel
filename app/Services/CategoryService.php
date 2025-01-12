<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        Gate::authorize('viewAny', Category::class);

        return $this->categoryRepository->getAll();
    }

    public function findById($id)
    {
        $category = $this->categoryRepository->findById($id);

        if ($category) {
            Gate::authorize('view', $category);
        }

        return $category;
    }

    public function createCategory(array $data)
    {
        Gate::authorize('create', [Category::class, Auth::user()]);

        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        Gate::authorize('update', Category::class);

        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function getParentCategories()
    {
        return $this->categoryRepository->getParentCategories();
    }

    public function getSubCategories($parentId)
    {
        return $this->categoryRepository->getSubCategories($parentId);
    }

    public function getCategoryWithPosts($id)
    {
        return $this->categoryRepository->getCategoryWithPosts($id);
    }

    public function getCategoryPosts($id)
    {
        return $this->categoryRepository->getCategoryWithPosts($id);
    }
}
