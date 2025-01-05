<?php

namespace App\Interfaces\Services;

interface TagServiceInterface
{
    public function getAllTags();
    public function getTagById($id);
    public function createTag(array $data);
    public function updateTag($id, array $data);
    public function deleteTag($id);
    public function getTagWithPosts($id);
    public function getPopularTags($limit = 10);
}
