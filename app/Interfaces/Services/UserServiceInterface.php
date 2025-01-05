<?php

namespace App\Interfaces\Services;

interface UserServiceInterface
{
    public function getAllUsers();
    public function getUserById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function findByEmail($email);
    public function getUserPosts($userId);
    public function getUserComments($userId);
    public function assignRole($userId, $roleId);
    public function removeRole($userId, $roleId);
    public function hasRole($userId, $roleName);
}
