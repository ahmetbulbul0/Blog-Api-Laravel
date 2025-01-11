<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Role $role): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->role_id === $role->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Role $role): bool
    {
        if (!$user->isAdmin()) {
            return false;
        }

        if ($role->name === Role::ADMIN) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Role $role): bool
    {
        if (!$user->isAdmin()) {
            return false;
        }

        if (in_array($role->name, [Role::ADMIN, Role::AUTHOR, Role::READER])) {
            return false;
        }

        if ($role->users()->count() > 0) {
            return false;
        }

        return true;
    }

    public function assignRole(User $user): bool
    {
        return $user->isAdmin();
    }

    public function removeRole(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewStatistics(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewUsers(User $user, Role $role): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAuthor() && $role->name === Role::READER) {
            return true;
        }

        return false;
    }

    public function manageDefaultRoles(User $user): bool
    {
        return false;
    }
}
