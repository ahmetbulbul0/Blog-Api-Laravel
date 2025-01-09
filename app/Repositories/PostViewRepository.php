<?php

namespace App\Repositories;

use App\Models\PostView;
use App\Interfaces\Repositories\PostViewRepositoryInterface;

class PostViewRepository implements PostViewRepositoryInterface
{
    protected $model;

    public function __construct(PostView $model)
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

    public function delete($id)
    {
        $view = $this->findById($id);
        return $view->delete();
    }

    public function getViewsByPost($postId)
    {
        return $this->model->where('post_id', $postId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getViewsByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getViewsCount($postId)
    {
        return $this->model->where('post_id', $postId)->count();
    }

    public function getViewsByDateRange($postId, $startDate, $endDate)
    {
        return $this->model->where('post_id', $postId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    public function getMostViewedPosts($limit = 10)
    {
        return $this->model->selectRaw('post_id, count(*) as views_count')
            ->with('post')
            ->groupBy('post_id')
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getPostViews($postId)
    {
        return $this->model->where('post_id', $postId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
