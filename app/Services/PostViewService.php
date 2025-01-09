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

    public function getAllPostViews()
    {
        return $this->postViewRepository->getAll();
    }

    public function getPostViewById($id)
    {
        return $this->postViewRepository->findById($id);
    }

    public function createPostView(array $data)
    {
        return $this->postViewRepository->create($data);
    }

    public function deletePostView($id)
    {
        return $this->postViewRepository->delete($id);
    }

    public function getPostViewsByPost($postId)
    {
        return $this->postViewRepository->getViewsByPost($postId);
    }

    public function getPostViewsByUser($userId)
    {
        return $this->postViewRepository->getViewsByUser($userId);
    }

    public function getPostViewsCount($postId)
    {
        return $this->postViewRepository->getViewsCount($postId);
    }

    public function getPostViewsByDateRange($postId, $startDate, $endDate)
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
