<?php

namespace App\Interfaces\Repositories;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findBySlug($slug);
    public function getParentCategories();
    public function getSubCategories($parentId);
    public function getCategoryWithPosts($id);
}
