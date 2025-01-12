<?php

namespace App\Interfaces\Services;

interface CategoryServiceInterface
{
    public function getAll();
    public function findById($id);
    public function createCategory(array $data);
    public function updateCategory($id, array $data);
    public function deleteCategory($id);
    public function getParentCategories();
    public function getSubCategories($parentId);
    public function getCategoryWithPosts($id);
    public function getCategoryPosts($id);
}
