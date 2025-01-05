<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Interfaces\Repositories\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $tag = $this->findById($id);
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        $tag = $this->findById($id);
        return $tag->delete();
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function getTagWithPosts($id)
    {
        return $this->model->with('posts')->findOrFail($id);
    }

    public function getPopularTags($limit = 10)
    {
        return $this->model->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
