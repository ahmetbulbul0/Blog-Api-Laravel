<?php

namespace App\Interfaces\Services;

use Illuminate\Http\UploadedFile;

interface PostServiceInterface
{
    public function getAllPosts();
    public function getPostById(int $id);
    public function createPost(array $data);
    public function updatePost(int $id, array $data);
    public function deletePost(int $id);
    public function getPublishedPosts();
    public function getDraftPosts();
    public function getArchivedPosts();
    public function handlePostImage(UploadedFile $image);
    public function getPopularPosts($limit = 10);
    public function getRecentPosts($limit = 10);
    public function getRelatedPosts($postId, $limit = 5);
}
