<?php

namespace App\Interfaces\Services;

interface PostServiceInterface
{
    public function getAllPosts();
    public function getPostById($id);
    public function createPost(array $data);
    public function updatePost($id, array $data);
    public function deletePost($id);
    public function getPostBySlug($slug);
    public function getPublishedPosts();
    public function getDraftPosts();
    public function getArchivedPosts();
    public function handlePostImage($image);
    public function removePostImage($postId);
    public function manageTags($postId, array $tagIds);
} 