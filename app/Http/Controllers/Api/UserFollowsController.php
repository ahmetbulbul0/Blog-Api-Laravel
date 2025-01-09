<?php

namespace App\Http\Controllers\Api;


use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Services\UserFollowServiceInterface;
use App\Interfaces\Services\UserServiceInterface;

class UserFollowsController extends Controller
{
    protected $userFollowService;
    protected $userServiceInterface;

    public function __construct(
        UserFollowServiceInterface $userFollowService,
        UserServiceInterface $userServiceInterface
    ) {
        $this->userFollowService = $userFollowService;
        $this->userServiceInterface = $userServiceInterface;
    }

    /**
     * @OA\Post(
     *     path="/authors/{id}/follow",
     *     tags={"Takip"},
     *     summary="Yazarı takip et (Sadece Okuyucu)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yazar ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Yazar başarıyla takip edildi")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Kendini takip etme hatası"),
     *     @OA\Response(response=403, ref="#/components/responses/Forbidden"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     */
    public function follow($id)
    {
        $author = $this->userServiceInterface->getUserById($id);

        if (!$author) {
            return ResponseHelper::notFound("Author not found");
        }

        if ($id === Auth::id()) {
            return ResponseHelper::error();
        }

        try {
            $this->userFollowService->follow($id);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

        return ResponseHelper::success();
    }

    /**
     * @OA\Delete(
     *     path="/authors/{id}/unfollow",
     *     tags={"Takip"},
     *     summary="Yazar takibini bırak (Sadece Okuyucu)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yazar ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Yazar takibi başarıyla kaldırıldı")
     *         )
     *     ),
     *     @OA\Response(response=403, ref="#/components/responses/Forbidden"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     */
    public function unfollow($id)
    {
        $author = $this->userServiceInterface->getUserById($id);

        if (!$author) {
            return ResponseHelper::notFound("Author not found");
        }

        if ($id === Auth::id()) {
            return ResponseHelper::forbidden();
        }

        try {
            $this->userFollowService->follow($id);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

        return ResponseHelper::success();
    }

    /**
     * @OA\Get(
     *     path="/authors/{id}/followers",
     *     tags={"Takip"},
     *     summary="Yazarın takipçilerini listele (Sadece Yazar)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yazar ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Takipçiler başarıyla getirildi"),
     *             @OA\Property(
     *                 property="followers",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=403, ref="#/components/responses/Forbidden"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     */
    public function followers($id)
    {
        $author = $this->userServiceInterface->getUserById($id);

        if (!$author) {
            return ResponseHelper::notFound("Author not found");
        }

        if ($id !== Auth::id() && !auth()->user()->isAdmin()) {
            return ResponseHelper::forbidden();
        }

        try {
            $followers = $this->userFollowService->followers($id);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

        return ResponseHelper::success($followers);
    }

    /**
     * @OA\Get(
     *     path="/authors/following",
     *     tags={"Takip"},
     *     summary="Takip edilen yazarları listele",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Takip edilen yazarlar başarıyla getirildi"),
     *             @OA\Property(
     *                 property="following",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function followings()
    {
        $followings = $this->userFollowService->followings();

        return ResponseHelper::success($followings);
    }
}
