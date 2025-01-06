<?php

namespace App\Interfaces\Services;

interface PostViewServiceInterface
{
    public function getAllViews();
    public function getViewById($id);
    public function createView(array $data);
    public function deleteView($id);
    public function getViewsByPost($postId);
    public function getViewsByUser($userId);
    public function getViewsCount($postId);
    public function getViewsByDateRange($postId, $startDate, $endDate);
    public function getMostViewedPosts($limit = 10);
    public function getPostViews($postId);
}
