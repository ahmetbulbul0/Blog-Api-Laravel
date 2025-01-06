<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Interfaces\Services\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Blog kategorileri yönetimi için API endpoint'leri"
 * )
 */
class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Tüm kategorileri listele",
     *     tags={"Categories"},
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
        $categories = $this->categoryService->getAllCategories();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Yeni kategori oluştur",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","slug"},
     *             @OA\Property(property="name", type="string", example="Technology"),
     *             @OA\Property(property="slug", type="string", example="technology"),
     *             @OA\Property(property="description", type="string", example="Technology related posts"),
     *             @OA\Property(property="parent_id", type="integer", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kategori başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Belirli bir kategoriyi getir",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kategori ID",
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
     *         description="Kategori bulunamadı"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Kategori güncelle",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kategori ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","slug"},
     *             @OA\Property(property="name", type="string", example="Updated Technology"),
     *             @OA\Property(property="slug", type="string", example="updated-technology"),
     *             @OA\Property(property="description", type="string", example="Updated technology related posts"),
     *             @OA\Property(property="parent_id", type="integer", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kategori başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kategori bulunamadı"
     *     )
     * )
     */
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = $this->categoryService->updateCategory($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Kategori sil",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kategori ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kategori başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kategori bulunamadı"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->categoryService->deleteCategory($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/parent",
     *     summary="Ana kategorileri listele",
     *     tags={"Categories"},
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
    public function parentCategories(): JsonResponse
    {
        $categories = $this->categoryService->getParentCategories();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}/sub",
     *     summary="Alt kategorileri listele",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Ana kategori ID",
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
    public function subCategories(int $id): JsonResponse
    {
        $categories = $this->categoryService->getSubCategories($id);
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}/posts",
     *     summary="Kategoriye ait gönderileri listele",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kategori ID",
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
    public function categoryPosts(int $id): JsonResponse
    {
        $posts = $this->categoryService->getCategoryPosts($id);
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }
}
