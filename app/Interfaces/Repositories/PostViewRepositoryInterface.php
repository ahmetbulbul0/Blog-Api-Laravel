<?php

namespace App\Interfaces\Repositories;

interface PostViewRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function delete($id);
    public function getViewsByPost($postId);
    public function getViewsByUser($userId);
    public function getViewsCount($postId);
    public function getViewsByDateRange($postId, $startDate, $endDate);
    public function getMostViewedPosts($limit = 10);
    public function getPostViews($postId);
}
