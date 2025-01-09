<?php

namespace App\Interfaces\Services;

interface PostViewServiceInterface
{
    public function getAllPostViews();
    public function getPostViewById($id);
    public function createPostView(array $data);
    public function deletePostView($id);
    public function getPostViewsByPost($postId);
    public function getPostViewsByUser($userId);
    public function getPostViewsCount($postId);
    public function getPostViewsByDateRange($postId, $startDate, $endDate);
    public function getMostViewedPosts($limit = 10);
    public function getPostViews($postId);
}
