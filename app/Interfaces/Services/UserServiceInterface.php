<?php

namespace App\Interfaces\Services;

interface UserServiceInterface
{
    public function getAllUsers();
    public function getUserById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getUserPosts($id);
    public function getUserComments($id);
    public function assignRole($userId, $roleId);
    public function removeRole($userId, $roleId);
}
