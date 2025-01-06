<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\PostViewServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Post Views",
 *     description="Blog gönderi görüntülenme yönetimi için API endpoint'leri"
 * )
 */
class PostViewController extends Controller
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
        $views = $this->postViewService->getAllPostViews();
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
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
    public function store(): JsonResponse
    {
        $view = $this->postViewService->createPostView();
        return response()->json([
            'status' => 'success',
            'message' => 'Post view created successfully',
            'data' => $view
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/post-views/most-viewed",
     *     summary="En çok görüntülenen gönderileri listele",
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
    public function mostViewedPosts(): JsonResponse
    {
        $posts = $this->postViewService->getMostViewedPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{postId}/views",
     *     summary="Gönderi görüntülenmelerini listele",
     *     tags={"Post Views"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
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
    public function postViews(int $postId): JsonResponse
    {
        $views = $this->postViewService->getPostViews($postId);
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{postId}/views/count",
     *     summary="Gönderi görüntülenme sayısını getir",
     *     tags={"Post Views"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="integer", example=42)
     *         )
     *     )
     * )
     */
    public function viewsCount(int $postId): JsonResponse
    {
        $count = $this->postViewService->getViewsCount($postId);
        return response()->json([
            'status' => 'success',
            'data' => $count
        ]);
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
        $views = $this->postViewService->getViewsByDateRange($postId, request('start_date'), request('end_date'));
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
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
        $views = $this->postViewService->getUserViews($userId);
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
    }
}
