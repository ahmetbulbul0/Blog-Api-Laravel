<?php

namespace App\Services;

use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Interfaces\Services\PostServiceInterface;
use Illuminate\Http\UploadedFile;

class PostService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAll();
    }

    public function getPostById(int $id)
    {
        return $this->postRepository->getPostById($id);
    }

    public function createPost(array $data)
    {
        return $this->postRepository->createPost($data);
    }

    public function updatePost(int $id, array $data)
    {
        return $this->postRepository->updatePost($id, $data);
    }

    public function deletePost(int $id)
    {
        return $this->postRepository->deletePost($id);
    }

    public function getPublishedPosts()
    {
        return $this->postRepository->getPublishedPosts();
    }

    public function getDraftPosts()
    {
        return $this->postRepository->getDraftPosts();
    }

    public function getArchivedPosts()
    {
        return $this->postRepository->getArchivedPosts();
    }

    public function handlePostImage(UploadedFile $image)
    {
        return $image->store('posts', 'public');
    }
}
