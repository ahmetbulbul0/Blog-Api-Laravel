<?php

namespace App\Services;

use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
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
