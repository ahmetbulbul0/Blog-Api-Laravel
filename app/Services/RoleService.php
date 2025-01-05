<?php

namespace App\Services;

use App\Interfaces\Services\RoleServiceInterface;
use App\Interfaces\Repositories\RoleRepositoryInterface;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->getAll();
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->findById($id);
    }

    public function createRole(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function updateRole($id, array $data)
    {
        return $this->roleRepository->update($id, $data);
    }

    public function deleteRole($id)
    {
        return $this->roleRepository->delete($id);
    }

    public function findByName($name)
    {
        return $this->roleRepository->findByName($name);
    }

    public function getRoleUsers($roleId)
    {
        return $this->roleRepository->getRoleUsers($roleId);
    }

    public function getUsersCount($roleId)
    {
        return $this->roleRepository->getUsersCount($roleId);
    }
}
