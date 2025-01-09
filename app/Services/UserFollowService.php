<?php

namespace App\Services;

use App\Interfaces\Services\UserFollowServiceInterface;
use App\Interfaces\Repositories\UserFollowRepositoryInterface;

class UserFollowService implements UserFollowServiceInterface
{
    protected $userFollowRepository;

    public function __construct(UserFollowRepositoryInterface $userFollowRepository)
    {
        $this->userFollowRepository = $userFollowRepository;
    }

    public function follow($userId) {
        return $this->userFollowRepository->follow($userId);
    }

    public function unfollow($userId) {
        return $this->userFollowRepository->unfollow($userId);
    }

    public function followers($userId) {
        return $this->userFollowRepository->followers($userId);
    }

    public function followings() {
        return $this->userFollowRepository->followings();
    }
}
