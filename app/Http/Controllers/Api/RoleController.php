<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Interfaces\Services\RoleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAllRoles();
        return response()->json([
            'status' => 'success',
            'data' => $roles
        ]);
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->createRole($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Role created successfully.',
            'data' => $role
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $role = $this->roleService->getRoleById($id);
        return response()->json([
            'status' => 'success',
            'data' => $role
        ]);
    }

    public function update(UpdateRoleRequest $request, $id): JsonResponse
    {
        $role = $this->roleService->updateRole($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully.',
            'data' => $role
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->roleService->deleteRole($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function roleUsers($id): JsonResponse
    {
        $users = $this->roleService->getRoleUsers($id);
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function usersCount($id): JsonResponse
    {
        $count = $this->roleService->getUsersCount($id);
        return response()->json([
            'status' => 'success',
            'data' => [
                'count' => $count
            ]
        ]);
    }
}
