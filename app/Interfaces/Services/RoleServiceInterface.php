<?php

namespace App\Interfaces\Services;

interface RoleServiceInterface
{
    public function getAllRoles();
    public function getRoleById($id);
    public function createRole(array $data);
    public function updateRole($id, array $data);
    public function deleteRole($id);
    public function findByName($name);
    public function getRoleUsers($roleId);
    public function getUsersCount($roleId);
}
