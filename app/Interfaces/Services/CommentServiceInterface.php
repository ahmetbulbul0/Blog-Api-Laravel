<?php

namespace App\Interfaces\Services;

interface CommentServiceInterface
{
    public function getAllComments();
    public function getCommentById($id);
    public function createComment(array $data);
    public function updateComment($id, array $data);
    public function deleteComment($id);
    public function getCommentsByPost($postId);
    public function getCommentsByUser($userId);
    public function getRecentComments($limit = 10);
    public function approveComment($id);
    public function rejectComment($id);
    public function getPostComments($postId);
    public function getUserComments($userId);
}
