<?php

namespace App\Services;

use App\Interfaces\Services\PostViewServiceInterface;
use App\Interfaces\Repositories\PostViewRepositoryInterface;

class PostViewService implements PostViewServiceInterface
{
    protected $postViewRepository;

    public function __construct(PostViewRepositoryInterface $postViewRepository)
    {
        $this->postViewRepository = $postViewRepository;
    }

    public function getAllViews()
    {
        return $this->postViewRepository->getAll();
    }

    public function getViewById($id)
    {
        return $this->postViewRepository->findById($id);
    }

    public function createView(array $data)
    {
        return $this->postViewRepository->create($data);
    }

    public function deleteView($id)
    {
        return $this->postViewRepository->delete($id);
    }

    public function getViewsByPost($postId)
    {
        return $this->postViewRepository->getViewsByPost($postId);
    }

    public function getViewsByUser($userId)
    {
        return $this->postViewRepository->getViewsByUser($userId);
    }

    public function getViewsCount($postId)
    {
        return $this->postViewRepository->getViewsCount($postId);
    }

    public function getViewsByDateRange($postId, $startDate, $endDate)
    {
        return $this->postViewRepository->getViewsByDateRange($postId, $startDate, $endDate);
    }

    public function getMostViewedPosts($limit = 10)
    {
        return $this->postViewRepository->getMostViewedPosts($limit);
    }

    public function getPostViews($postId)
    {
        return $this->postViewRepository->getPostViews($postId);
    }
}
