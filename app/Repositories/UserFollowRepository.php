<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\UserFollowRepositoryInterface;

class UserFollowRepository implements UserFollowRepositoryInterface
{
    protected $model;

    public function __construct(UserFollow $model)
    {
        $this->model = $model;
    }

    public function follow($userId)
    {
        return Auth::user()->followedAuthors()->attach($userId);
    }

    public function unfollow($userId)
    {
        return Auth::user()->followedAuthors()->detach($userId);
    }

    public function followers($userId)
    {
        $user = User::where("id", $userId)->first();
        return $user->followers()->with('role')->paginate(15);
    }

    public function followings()
    {
        return Auth::user()->followedAuthors()->get();
    }
}
