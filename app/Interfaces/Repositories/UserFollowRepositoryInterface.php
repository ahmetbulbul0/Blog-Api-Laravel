<?php

namespace App\Interfaces\Repositories;

interface UserFollowRepositoryInterface
{
    public function follow($userId);
    public function unfollow($userId);
    public function followers($userId);
    public function followings();
}
