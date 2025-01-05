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
        $user = $this->findById($id);
        $user->update($data);
        return $user;
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

    public function assignRole($userId, $roleId)
    {
        $user = $this->findById($userId);
        $user->role_id = $roleId;
        $user->save();
        return $user;
    }

    public function removeRole($userId, $roleId)
    {
        $user = $this->findById($userId);
        if ($user->role_id == $roleId) {
            $user->role_id = null;
            $user->save();
        }
        return $user;
    }

    public function hasRole($userId, $roleName)
    {
        $user = $this->findById($userId);
        return $user->role && $user->role->name === $roleName;
    }
}
