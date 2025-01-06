<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Interfaces\Services\TagServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;

/**
 * @OA\Tag(
 *     name="Tags",
 *     description="Blog etiketleri yönetimi için API endpoint'leri"
 * )
 */
class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @OA\Get(
     *     path="/api/tags",
     *     summary="Tüm etiketleri listele",
     *     tags={"Tags"},
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
        $tags = $this->tagService->getAllTags();
        return response()->json([
            'status' => 'success',
            'data' => $tags
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tags",
     *     summary="Yeni etiket oluştur",
     *     tags={"Tags"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","slug"},
     *             @OA\Property(property="name", type="string", example="Technology"),
     *             @OA\Property(property="slug", type="string", example="technology")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Etiket başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tag created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->tagService->createTag($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Tag created successfully',
            'data' => $tag
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/{id}",
     *     summary="Belirli bir etiketi getir",
     *     tags={"Tags"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Etiket ID",
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
     *         description="Etiket bulunamadı"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $tag = $this->tagService->getTagById($id);
        return response()->json([
            'status' => 'success',
            'data' => $tag
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/tags/{id}",
     *     summary="Etiket güncelle",
     *     tags={"Tags"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Etiket ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","slug"},
     *             @OA\Property(property="name", type="string", example="Updated Technology"),
     *             @OA\Property(property="slug", type="string", example="updated-technology")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Etiket başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tag updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Etiket bulunamadı"
     *     )
     * )
     */
    public function update(UpdateTagRequest $request, int $id): JsonResponse
    {
        $tag = $this->tagService->updateTag($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Tag updated successfully',
            'data' => $tag
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tags/{id}",
     *     summary="Etiket sil",
     *     tags={"Tags"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Etiket ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Etiket başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tag deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Etiket bulunamadı"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->tagService->deleteTag($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Tag deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/popular",
     *     summary="Popüler etiketleri listele",
     *     tags={"Tags"},
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
    public function popularTags(): JsonResponse
    {
        $tags = $this->tagService->getPopularTags();
        return response()->json([
            'status' => 'success',
            'data' => $tags
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/{id}/posts",
     *     summary="Etikete ait gönderileri listele",
     *     tags={"Tags"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Etiket ID",
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
    public function tagPosts(int $id): JsonResponse
    {
        try {
            $posts = $this->tagService->getTagPosts($id);
            return ResponseHelper::success($posts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
