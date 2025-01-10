<?php

namespace App\Services;

use App\Interfaces\Repositories\RoleRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data, string $roleName = null)
    {
        if ($roleName) {
            $role = $this->roleRepository->findByName($roleName);
        } else {
            $role = $this->roleRepository->findById($data["roleId"]);
        }

        $data = [
            "role_id" => $role->id,
            "first_name" => Str::lower($data["firstName"]),
            "last_name" => Str::lower($data["lastName"]),
            "username" => Str::lower($data["username"]),
            "email" => Str::lower($data["email"]),
            'password' => Hash::make($data["password"]),
            "occupation" => Str::lower($data["occupation"]),
            "date_of_birth" => $data["dateOfBirth"],
            "location" => Str::lower($data["location"]),
            "preferred_language" => Str::lower($data["preferredLanguage"]),
            "gender" => Str::lower($data["gender"]),
            "bio" => isset($data["bio"]) ? $data["bio"] : null
        ];

        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->update($id, $data);
    }

    public function updateUserProfilePicture($userId, $profilePictureFile)
    {
        $data["profile_picture"] = $profilePictureFile->store('profile-pictures', 'public');
        return $this->updateUser($userId, $data);
    }

    public function attachInterests($userId, $interests)
    {
        $this->userRepository->attachInterests($userId, $interests);
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

    public function create(array $data)
    {
        return User::create($data);
    }
}
