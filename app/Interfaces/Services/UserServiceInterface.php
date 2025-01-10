<?php

namespace App\Interfaces\Services;

interface UserServiceInterface
{
    public function getAllUsers();
    public function getUserById($id);
    public function createUser(array $data, string $roleName);
    public function updateUser($id, array $data);
    public function updateUserProfilePicture($userId, $profilePictureFile);
    public function attachInterests($userId, $interests);
    public function deleteUser($id);
    public function getUserPosts($id);
    public function getUserComments($id);
}
