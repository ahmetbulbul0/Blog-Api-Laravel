<?php

namespace App\Services;

use App\Interfaces\Services\TagServiceInterface;
use App\Interfaces\Repositories\TagRepositoryInterface;

class TagService implements TagServiceInterface
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        return $this->tagRepository->getAll();
    }

    public function getTagById($id)
    {
        return $this->tagRepository->findById($id);
    }

    public function createTag(array $data)
    {
        return $this->tagRepository->create($data);
    }

    public function updateTag($id, array $data)
    {
        return $this->tagRepository->update($id, $data);
    }

    public function deleteTag($id)
    {
        return $this->tagRepository->delete($id);
    }

    public function getTagWithPosts($id)
    {
        return $this->tagRepository->getTagWithPosts($id);
    }

    public function getPopularTags($limit = 10)
    {
        return $this->tagRepository->getPopularTags($limit);
    }
}
