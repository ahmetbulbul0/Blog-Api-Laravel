<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostView\StorePostViewRequest;
use App\Interfaces\Services\PostViewServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PostViewController extends Controller
{
    protected $postViewService;

    public function __construct(PostViewServiceInterface $postViewService)
    {
        $this->postViewService = $postViewService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $views = $this->postViewService->getAllViews();
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
    }

    public function store(StorePostViewRequest $request): JsonResponse
    {
        $view = $this->postViewService->createView($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'View recorded successfully.',
            'data' => $view
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $view = $this->postViewService->getViewById($id);
        return response()->json([
            'status' => 'success',
            'data' => $view
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->postViewService->deleteView($id);
        return response()->json([
            'status' => 'success',
            'message' => 'View deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function postViews($postId): JsonResponse
    {
        $views = $this->postViewService->getViewsByPost($postId);
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
    }

    public function userViews($userId): JsonResponse
    {
        $views = $this->postViewService->getViewsByUser($userId);
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
    }

    public function viewsCount($postId): JsonResponse
    {
        $count = $this->postViewService->getViewsCount($postId);
        return response()->json([
            'status' => 'success',
            'data' => [
                'count' => $count
            ]
        ]);
    }

    public function viewsByDateRange(Request $request, $postId): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $views = $this->postViewService->getViewsByDateRange($postId, $startDate, $endDate);
        return response()->json([
            'status' => 'success',
            'data' => $views
        ]);
    }

    public function mostViewedPosts(): JsonResponse
    {
        $posts = $this->postViewService->getMostViewedPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }
}
