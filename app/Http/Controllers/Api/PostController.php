<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Interfaces\Services\PostServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $posts = $this->postService->getAllPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
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
     *             required={"title","slug","content","category_id","status"},
     *             @OA\Property(property="title", type="string", example="My First Blog Post"),
     *             @OA\Property(property="slug", type="string", example="my-first-blog-post"),
     *             @OA\Property(property="content", type="string", example="This is my first blog post content."),
     *             @OA\Property(property="excerpt", type="string", example="A brief excerpt of the post"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", enum={"draft", "published", "archived"}, example="published"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="integer"), example={1,2,3})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Gönderi başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Post created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->postService->createPost($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'data' => $post
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Belirli bir gönderiyi getir",
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
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Gönderi bulunamadı"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPostById($id);
        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
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
     *             required={"title","slug","content","category_id","status"},
     *             @OA\Property(property="title", type="string", example="Updated Blog Post"),
     *             @OA\Property(property="slug", type="string", example="updated-blog-post"),
     *             @OA\Property(property="content", type="string", example="Updated content."),
     *             @OA\Property(property="excerpt", type="string", example="Updated excerpt"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", enum={"draft", "published", "archived"}, example="published"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="integer"), example={1,2,3})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gönderi başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Post updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Gönderi bulunamadı"
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        $post = $this->postService->updatePost($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
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
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Post deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Gönderi bulunamadı"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->postService->deletePost($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
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
    public function published(): JsonResponse
    {
        $posts = $this->postService->getPublishedPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
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
    public function drafts(): JsonResponse
    {
        $posts = $this->postService->getDraftPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
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
    public function archived(): JsonResponse
    {
        $posts = $this->postService->getArchivedPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }
}
