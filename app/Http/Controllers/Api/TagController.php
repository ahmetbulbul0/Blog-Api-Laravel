<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Interfaces\Services\TagServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAllTags();
        return response()->json([
            'status' => 'success',
            'data' => $tags
        ]);
    }

    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->tagService->createTag($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Tag created successfully.',
            'data' => $tag
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $tag = $this->tagService->getTagById($id);
        return response()->json([
            'status' => 'success',
            'data' => $tag
        ]);
    }

    public function update(UpdateTagRequest $request, $id): JsonResponse
    {
        $tag = $this->tagService->updateTag($id, $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Tag updated successfully.',
            'data' => $tag
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->tagService->deleteTag($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Tag deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    public function tagPosts($id): JsonResponse
    {
        $tag = $this->tagService->getTagWithPosts($id);
        return response()->json([
            'status' => 'success',
            'data' => $tag
        ]);
    }

    public function popularTags(): JsonResponse
    {
        $tags = $this->tagService->getPopularTags();
        return response()->json([
            'status' => 'success',
            'data' => $tags
        ]);
    }
}
