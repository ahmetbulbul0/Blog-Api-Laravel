<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostViewResource;
use App\Http\Requests\PostView\StorePostViewRequest;
use App\Interfaces\Services\PostViewServiceInterface;

/**
 * @OA\Tag(
 *     name="Post Views",
 *     description="Blog gönderi görüntülenme yönetimi için API endpoint'leri"
 * )
 */
class PostViewsController extends Controller
{
    protected $postViewService;

    public function __construct(PostViewServiceInterface $postViewService)
    {
        $this->postViewService = $postViewService;
    }

    /**
     * @OA\Get(
     *     path="/api/post-views",
     *     summary="Tüm görüntülenmeleri listele",
     *     tags={"Post Views"},
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
            $postViews = $this->postViewService->getAllPostViews();
            return ResponseHelper::success(PostViewResource::collection($postViews));
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/post-views",
     *     summary="Yeni görüntülenme kaydet",
     *     tags={"Post Views"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id"},
     *             @OA\Property(property="post_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="ip_address", type="string", example="192.168.1.1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Görüntülenme başarıyla kaydedildi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Post view created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StorePostViewRequest $request): JsonResponse
    {
        $view = $this->postViewService->createPostView($request->validated());
        return ResponseHelper::created($view);
    }

    /**
     * @OA\Get(
     *     path="/api/post-views/{id}",
     *     summary="Belirli bir görüntülenme detayını getir",
     *     tags={"Post Views"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Görüntülenme ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             )
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $postView = $this->postViewService->getPostViewById($id);
            if (!$postView) {
                return ResponseHelper::notFound('Post view not found');
            }
            return ResponseHelper::success(new PostViewResource($postView));
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/most-viewed",
     *     summary="En çok görüntülenen gönderileri listele",
     *     tags={"PostViews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         description="Limit",
     *         @OA\Schema(type="integer", default=10)
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
    public function mostViewedPosts(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $posts = $this->postViewService->getMostViewedPosts($limit);
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}/views",
     *     summary="Gönderinin görüntülenme detaylarını listele",
     *     tags={"PostViews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
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
    public function postViews(int $postId): JsonResponse
    {
        try {
            $views = $this->postViewService->getPostViews($postId);
            return ResponseHelper::success($views);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}/views/count",
     *     summary="Gönderinin toplam görüntülenme sayısını getir",
     *     tags={"PostViews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="count", type="integer", example=100)
     *             )
     *         )
     *     )
     * )
     */
    public function viewsCount(int $postId): JsonResponse
    {
        try {
            $count = $this->postViewService->getPostViewsCount($postId);
            return ResponseHelper::success(['count' => $count]);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{postId}/views/date-range",
     *     summary="Belirli tarih aralığındaki görüntülenmeleri getir",
     *     tags={"Post Views"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         required=true,
     *         description="Başlangıç tarihi (Y-m-d)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         required=true,
     *         description="Bitiş tarihi (Y-m-d)",
     *         @OA\Schema(type="string")
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
    public function viewsByDateRange(int $postId): JsonResponse
    {
        $views = $this->postViewService->getPostViewsByDateRange($postId, request('start_date'), request('end_date'));
        return ResponseHelper::success($views);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{userId}/views",
     *     summary="Kullanıcının görüntülemelerini listele",
     *     tags={"Post Views"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userId",
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
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function userViews(int $userId): JsonResponse
    {
        $views = $this->postViewService->getPostViewsByUser($userId);
        return ResponseHelper::success($views);
    }
}
