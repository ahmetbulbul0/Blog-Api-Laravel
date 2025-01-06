<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Interfaces\Services\PostServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="Blog gönderileri yönetimi için API endpoint'leri"
 * )
 */
class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Tüm gönderileri listele",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
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
    public function index(): JsonResponse
    {
        try {
            $posts = $this->postService->getAllPosts();
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Yeni gönderi oluştur",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","slug","content","category_id","user_id"},
     *             @OA\Property(property="title", type="string", example="Sample Post"),
     *             @OA\Property(property="slug", type="string", example="sample-post"),
     *             @OA\Property(property="content", type="string", example="Post content"),
     *             @OA\Property(property="excerpt", type="string", example="Post excerpt"),
     *             @OA\Property(property="published_at", type="string", format="date-time"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Gönderi başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        try {
            $post = $this->postService->createPost($request->validated());
            return ResponseHelper::created($post, 'Post created successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Gönderi detaylarını getir",
     *     tags={"Posts"},
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
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $post = $this->postService->getPostById($id);
            if (!$post) {
                return ResponseHelper::notFound('Post not found');
            }
            return ResponseHelper::success($post);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Gönderi güncelle",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","slug","content","category_id","user_id"},
     *             @OA\Property(property="title", type="string", example="Updated Post"),
     *             @OA\Property(property="slug", type="string", example="updated-post"),
     *             @OA\Property(property="content", type="string", example="Updated content"),
     *             @OA\Property(property="excerpt", type="string", example="Updated excerpt"),
     *             @OA\Property(property="published_at", type="string", format="date-time"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gönderi başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        try {
            $post = $this->postService->updatePost($id, $request->validated());
            if (!$post) {
                return ResponseHelper::notFound('Post not found');
            }
            return ResponseHelper::success($post, 'Post updated successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Gönderi sil",
     *     tags={"Posts"},
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
     *         description="Gönderi başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->postService->deletePost($id);
            if (!$result) {
                return ResponseHelper::notFound('Post not found');
            }
            return ResponseHelper::success(null, 'Post deleted successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/published",
     *     summary="Yayınlanmış gönderileri listele",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
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
    public function publishedPosts(): JsonResponse
    {
        try {
            $posts = $this->postService->getPublishedPosts();
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/drafts",
     *     summary="Taslak gönderileri listele",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
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
    public function draftPosts(): JsonResponse
    {
        try {
            $posts = $this->postService->getDraftPosts();
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/archived",
     *     summary="Arşivlenmiş gönderileri listele",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
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
    public function archivedPosts(): JsonResponse
    {
        try {
            $posts = $this->postService->getArchivedPosts();
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/popular",
     *     summary="En popüler gönderileri listele",
     *     tags={"Posts"},
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
    public function popularPosts(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $posts = $this->postService->getPopularPosts($limit);
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/recent",
     *     summary="En son gönderileri listele",
     *     tags={"Posts"},
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
    public function recentPosts(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $posts = $this->postService->getRecentPosts($limit);
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}/related",
     *     summary="İlgili gönderileri listele",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Gönderi ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         description="Limit",
     *         @OA\Schema(type="integer", default=5)
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
    public function relatedPosts(int $id, Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 5);
            $posts = $this->postService->getRelatedPosts($id, $limit);
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
