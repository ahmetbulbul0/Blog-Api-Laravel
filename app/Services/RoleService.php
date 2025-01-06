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

    public function getRoleUsers($id)
    {
        return $this->roleRepository->getRoleWithUsers($id);
    }

    public function getUsersCount($id)
    {
        return $this->roleRepository->getUsersCount($id);
    }
}
