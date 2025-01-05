<?php

namespace App\Interfaces\Repositories;

interface TagRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findBySlug($slug);
    public function getTagWithPosts($id);
    public function getPopularTags($limit = 10);
}
