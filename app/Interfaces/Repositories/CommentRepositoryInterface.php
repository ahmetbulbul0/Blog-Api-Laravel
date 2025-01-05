<?php

namespace App\Interfaces\Repositories;

interface CommentRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getCommentsByPost($postId);
    public function getCommentsByUser($userId);
    public function getRecentComments($limit = 10);
    public function approveComment($id);
    public function rejectComment($id);
}
