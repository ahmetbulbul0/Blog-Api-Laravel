<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Interfaces\Repositories\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    protected $model;

    public function __construct(Comment $model)
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
        $comment = $this->findById($id);
        $comment->update($data);
        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->findById($id);
        return $comment->delete();
    }

    public function getCommentsByPost($postId)
    {
        return $this->model->where('post_id', $postId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCommentsByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRecentComments($limit = 10)
    {
        return $this->model->with(['user', 'post'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function approveComment($id)
    {
        $comment = $this->findById($id);
        $comment->update(['status' => 'approved']);
        return $comment;
    }

    public function rejectComment($id)
    {
        $comment = $this->findById($id);
        $comment->update(['status' => 'rejected']);
        return $comment;
    }
}
