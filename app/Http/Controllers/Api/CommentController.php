<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Interfaces\Services\CommentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $comments = $this->commentService->getAllComments();
        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = $this->commentService->createComment($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully.',
            'data' => $comment
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $comment = $this->commentService->getCommentById($id);
        return response()->json([
            'status' => 'success',
            'data' => $comment
        ]);
    }

    public function update(UpdateCommentRequest $request, $id): JsonResponse
    {
        $comment = $this->commentService->updateComment($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Comment updated successfully.',
            'data' => $comment
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->commentService->deleteComment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function postComments($postId): JsonResponse
    {
        $comments = $this->commentService->getCommentsByPost($postId);
        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    public function userComments($userId): JsonResponse
    {
        $comments = $this->commentService->getCommentsByUser($userId);
        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    public function recentComments(): JsonResponse
    {
        $comments = $this->commentService->getRecentComments();
        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    public function approve($id): JsonResponse
    {
        $comment = $this->commentService->approveComment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment approved successfully.',
            'data' => $comment
        ]);
    }

    public function reject($id): JsonResponse
    {
        $comment = $this->commentService->rejectComment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment rejected successfully.',
            'data' => $comment
        ]);
    }
}
