<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findByEmail($email);
    public function getUserPosts($userId);
    public function getUserComments($userId);
    public function assignRole($userId, $roleId);
    public function removeRole($userId, $roleId);
    public function hasRole($userId, $roleName);
}
