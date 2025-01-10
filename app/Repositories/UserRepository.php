<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->findById($id)->update($data);
    }

    public function attachInterests($id, $interests) {
        return $this->findById($id)->interests()->attach($interests);
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->firstOrFail();
    }

    public function getUserPosts($userId)
    {
        return $this->model->findOrFail($userId)->posts;
    }

    public function getUserComments($userId)
    {
        return $this->model->findOrFail($userId)->comments;
    }

    public function hasRole($userId, $roleName)
    {
        return $this->findById($userId)->role->name === $roleName;
    }
}
