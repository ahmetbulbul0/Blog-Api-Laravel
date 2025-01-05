<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully.',
            'data' => $user
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'data' => $user
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function userPosts($id): JsonResponse
    {
        $posts = $this->userService->getUserPosts($id);
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function userComments($id): JsonResponse
    {
        $comments = $this->userService->getUserComments($id);
        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    public function assignRole($userId, $roleId): JsonResponse
    {
        $user = $this->userService->assignRole($userId, $roleId);
        return response()->json([
            'status' => 'success',
            'message' => 'Role assigned successfully.',
            'data' => $user
        ]);
    }

    public function removeRole($userId, $roleId): JsonResponse
    {
        $user = $this->userService->removeRole($userId, $roleId);
        return response()->json([
            'status' => 'success',
            'message' => 'Role removed successfully.',
            'data' => $user
        ]);
    }
}
