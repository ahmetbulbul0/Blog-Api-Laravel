<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Interfaces\Services\CommentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Resources\CommentResource;

/**
 * @OA\Tag(
 *     name="Comments",
 *     description="Blog yorumları yönetimi için API endpoint'leri"
 * )
 */
class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @OA\Get(
     *     path="/api/comments",
     *     summary="Tüm yorumları listele",
     *     tags={"Comments"},
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
            $comments = $this->commentService->getAllComments();
            return ResponseHelper::success(CommentResource::collection($comments));
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     summary="Yeni yorum oluştur",
     *     tags={"Comments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id","content"},
     *             @OA\Property(property="post_id", type="integer", example=1),
     *             @OA\Property(property="content", type="string", example="This is a great post!"),
     *             @OA\Property(property="parent_id", type="integer", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Yorum başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Comment created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        try {
            $comment = $this->commentService->createComment($request->validated());
            return ResponseHelper::created(new CommentResource($comment), 'Comment created successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/comments/{id}",
     *     summary="Belirli bir yorumu getir",
     *     tags={"Comments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yorum ID",
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
     *         description="Yorum bulunamadı"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $comment = $this->commentService->getCommentById($id);
            if (!$comment) {
                return ResponseHelper::notFound('Comment not found');
            }
            return ResponseHelper::success(new CommentResource($comment));
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     summary="Yorum güncelle",
     *     tags={"Comments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yorum ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="Updated comment content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Yorum başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Comment updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Yorum bulunamadı"
     *     )
     * )
     */
    public function update(StoreCommentRequest $request, int $id): JsonResponse
    {
        try {
            $comment = $this->commentService->updateComment($id, $request->validated());
            if (!$comment) {
                return ResponseHelper::notFound('Comment not found');
            }
            return ResponseHelper::success(new CommentResource($comment), 'Comment updated successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     summary="Yorum sil",
     *     tags={"Comments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yorum ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Yorum başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Comment deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Yorum bulunamadı"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->commentService->deleteComment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/comments/recent",
     *     summary="Son yorumları listele",
     *     tags={"Comments"},
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
    public function recentComments(): JsonResponse
    {
        $comments = $this->commentService->getRecentComments();
        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{postId}/comments",
     *     summary="Gönderiye ait yorumları listele",
     *     tags={"Comments"},
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
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function postComments(int $postId): JsonResponse
    {
        try {
            $comments = $this->commentService->getPostComments($postId);
            return ResponseHelper::success($comments);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{userId}/comments",
     *     summary="Kullanıcıya ait yorumları listele",
     *     tags={"Comments"},
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
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function userComments(int $userId): JsonResponse
    {
        try {
            $comments = $this->commentService->getUserComments($userId);
            return ResponseHelper::success($comments);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/comments/{id}/approve",
     *     summary="Yorumu onayla",
     *     tags={"Comments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yorum ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Yorum başarıyla onaylandı",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Comment approved successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function approve(int $id): JsonResponse
    {
        $comment = $this->commentService->approveComment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment approved successfully',
            'data' => $comment
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/api/comments/{id}/reject",
     *     summary="Yorumu reddet",
     *     tags={"Comments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yorum ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Yorum başarıyla reddedildi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Comment rejected successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function reject(int $id): JsonResponse
    {
        $comment = $this->commentService->rejectComment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment rejected successfully',
            'data' => $comment
        ]);
    }
}
