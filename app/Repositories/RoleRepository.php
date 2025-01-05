<?php

namespace App\Repositories;

use App\Models\Role;
use App\Interfaces\Repositories\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function __construct(Role $model)
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
        $role = $this->findById($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        $role = $this->findById($id);
        return $role->delete();
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    public function getRoleUsers($roleId)
    {
        return $this->model->findOrFail($roleId)->users;
    }

    public function getUsersCount($roleId)
    {
        return $this->model->findOrFail($roleId)->users()->count();
    }
}
