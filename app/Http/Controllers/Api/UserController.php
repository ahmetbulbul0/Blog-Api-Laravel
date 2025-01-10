<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Kullanıcı yönetimi için API endpoint'leri"
 * )
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Tüm kullanıcıları listele",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $users = $this->userService->getAllUsers();
            return ResponseHelper::success(UserResource::collection($users));
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Yeni kullanıcı oluştur",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","role_id"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="role_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kullanıcı başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request->validated());
            return ResponseHelper::created(new UserResource($user), 'User created successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Belirli bir kullanıcıyı getir",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kullanıcı bulunamadı"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);
            if (!$user) {
                return ResponseHelper::notFound('User not found');
            }
            return ResponseHelper::success(new UserResource($user));
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Kullanıcı güncelle",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="updated.john@example.com"),
     *             @OA\Property(property="role_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kullanıcı başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kullanıcı bulunamadı"
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            if (!$user) {
                return ResponseHelper::notFound('User not found');
            }
            return ResponseHelper::success(new UserResource($user), 'User updated successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Kullanıcı sil",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kullanıcı başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kullanıcı bulunamadı"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return ResponseHelper::success();
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/posts",
     *     summary="Kullanıcıya ait gönderileri listele",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function userPosts(int $id): JsonResponse
    {
        try {
            $posts = $this->userService->getUserPosts($id);
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/comments",
     *     summary="Kullanıcıya ait yorumları listele",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function userComments(int $id): JsonResponse
    {
        try {
            $comments = $this->userService->getUserComments($id);
            return ResponseHelper::success($comments);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users/{userId}/roles/{roleId}",
     *     summary="Kullanıcıya rol ata",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="roleId",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol başarıyla atandı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role assigned successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function assignRole(int $userId, int $roleId): JsonResponse
    {
        $user = $this->userService->assignRole($userId, $roleId);
        return response()->json([
            'status' => 'success',
            'message' => 'Role assigned successfully',
            'data' => $user
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{userId}/roles/{roleId}",
     *     summary="Kullanıcıdan rol kaldır",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="Kullanıcı ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="roleId",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol başarıyla kaldırıldı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role removed successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function removeRole(int $userId, int $roleId): JsonResponse
    {
        $user = $this->userService->removeRole($userId, $roleId);
        return response()->json([
            'status' => 'success',
            'message' => 'Role removed successfully',
            'data' => $user
        ]);
    }
}
