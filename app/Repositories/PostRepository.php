<?php

namespace App\Repositories;

use App\Models\Post;
use App\Interfaces\Repositories\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->model->with(['user', 'category', 'tags'])
            ->withCount(['comments', 'views'])
            ->latest()
            ->paginate(10);
    }

    public function findById($id): ?Post
    {
        return $this->model->with(['user', 'category', 'tags', 'comments' => function ($query) {
            $query->approved()->whereNull('parent_id');
        }])->findOrFail($id);
    }

    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        $post = $this->findById($id);
        return $post->update($data);
    }

    public function delete($id): bool
    {
        $post = $this->findById($id);
        return $post->delete();
    }

    public function findBySlug($slug): ?Post
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function getPublishedPosts(): Collection
    {
        return $this->model->published()->latest()->get();
    }

    public function getDraftPosts(): Collection
    {
        return $this->model->draft()->latest()->get();
    }

    public function getArchivedPosts(): Collection
    {
        return $this->model->archived()->latest()->get();
    }

    public function attachTags($postId, array $tagIds): void
    {
        $post = $this->findById($postId);
        $post->tags()->attach($tagIds);
    }

    public function syncTags($postId, array $tagIds): void
    {
        $post = $this->findById($postId);
        $post->tags()->sync($tagIds);
    }

    public function detachTags($postId, array $tagIds): void
    {
        $post = $this->findById($postId);
        $post->tags()->detach($tagIds);
    }
} 