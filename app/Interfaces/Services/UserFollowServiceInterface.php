<?php

namespace App\Interfaces\Services;

interface UserFollowServiceInterface
{
    public function follow($userId);
    public function unfollow($userId);
    public function followers($userId);
    public function followings();
}
