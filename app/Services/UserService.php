<?php

namespace App\Services;

use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

    public function getUserPosts($id)
    {
        return $this->userRepository->getUserPosts($id);
    }

    public function getUserComments($id)
    {
        return $this->userRepository->getUserPosts($id);
    }

    public function assignRole($userId, $roleId)
    {
        return $this->userRepository->assignRole($userId, $roleId);
    }

    public function removeRole($userId, $roleId)
    {
        return $this->userRepository->removeRole($userId, $roleId);
    }

    public function create(array $data)
    {
        return User::create($data);
    }
}
