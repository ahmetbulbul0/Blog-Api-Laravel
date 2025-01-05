<?php

namespace App\Interfaces\Repositories;

interface PostRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findBySlug($slug);
    public function getPublishedPosts();
    public function getDraftPosts();
    public function getArchivedPosts();
    public function attachTags($postId, array $tagIds);
    public function syncTags($postId, array $tagIds);
    public function detachTags($postId, array $tagIds);
} 