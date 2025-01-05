<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Interfaces\Services\PostServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->postService->createPost($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Blog yazısı başarıyla oluşturuldu.',
            'data' => $post
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $post = $this->postService->getPostById($id);
        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    public function update(UpdatePostRequest $request, $id): JsonResponse
    {
        $post = $this->postService->updatePost($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Blog yazısı başarıyla güncellendi.',
            'data' => $post
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->postService->deletePost($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Blog yazısı başarıyla silindi.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function published(): JsonResponse
    {
        $posts = $this->postService->getPublishedPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function drafts(): JsonResponse
    {
        $posts = $this->postService->getDraftPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function archived(): JsonResponse
    {
        $posts = $this->postService->getArchivedPosts();
        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }
} 