<?php

namespace App\Services;

use App\Interfaces\Services\CommentServiceInterface;
use App\Interfaces\Repositories\CommentRepositoryInterface;

class CommentService implements CommentServiceInterface
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComments()
    {
        return $this->commentRepository->getAll();
    }

    public function getCommentById($id)
    {
        return $this->commentRepository->findById($id);
    }

    public function createComment(array $data)
    {
        // Kullanıcı ID'sini otomatik ekle
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        return $this->commentRepository->create($data);
    }

    public function updateComment($id, array $data)
    {
        return $this->commentRepository->update($id, $data);
    }

    public function deleteComment($id)
    {
        return $this->commentRepository->delete($id);
    }

    public function getCommentsByPost($postId)
    {
        return $this->commentRepository->getCommentsByPost($postId);
    }

    public function getCommentsByUser($userId)
    {
        return $this->commentRepository->getCommentsByUser($userId);
    }

    public function getRecentComments($limit = 10)
    {
        return $this->commentRepository->getRecentComments($limit);
    }

    public function approveComment($id)
    {
        return $this->commentRepository->approveComment($id);
    }

    public function rejectComment($id)
    {
        return $this->commentRepository->rejectComment($id);
    }
}
