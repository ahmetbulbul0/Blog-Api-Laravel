<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Interfaces\Services\RoleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Roles",
 *     description="Kullanıcı rolleri yönetimi için API endpoint'leri"
 * )
 */
class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Tüm rolleri listele",
     *     tags={"Roles"},
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
        $roles = $this->roleService->getAllRoles();
        return response()->json([
            'status' => 'success',
            'data' => $roles
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Yeni rol oluştur",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="editor"),
     *             @OA\Property(property="description", type="string", example="Editor role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rol başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->createRole($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Role created successfully',
            'data' => $role
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     summary="Belirli bir rolü getir",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
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
     *         description="Rol bulunamadı"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->getRoleById($id);
        return response()->json([
            'status' => 'success',
            'data' => $role
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Rol güncelle",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="senior-editor"),
     *             @OA\Property(property="description", type="string", example="Senior Editor role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol bulunamadı"
     *     )
     * )
     */
    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        $role = $this->roleService->updateRole($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully',
            'data' => $role
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Rol sil",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol bulunamadı"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->roleService->deleteRole($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}/users",
     *     summary="Role sahip kullanıcıları listele",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
     *         @OA\Schema(type="integer")
     *     ),
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
    public function roleUsers(int $id): JsonResponse
    {
        $users = $this->roleService->getRoleUsers($id);
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}/users/count",
     *     summary="Role sahip kullanıcı sayısını getir",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rol ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="integer", example=5)
     *         )
     *     )
     * )
     */
    public function usersCount(int $id): JsonResponse
    {
        $count = $this->roleService->getRoleUsersCount($id);
        return response()->json([
            'status' => 'success',
            'data' => $count
        ]);
    }
}
