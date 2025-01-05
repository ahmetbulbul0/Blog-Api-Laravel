<?php

namespace App\Services;

use App\Interfaces\Services\PostServiceInterface;
use App\Interfaces\Repositories\PostRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function getPostById($id)
    {
        return $this->postRepository->findById($id);
    }

    public function createPost(array $data)
    {
        // Slug oluştur
        $data['slug'] = Str::slug($data['title']);
        
        // Kullanıcı ID'sini ekle
        $data['user_id'] = auth()->id();

        // Eğer resim varsa işle
        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            $data['featured_image'] = $this->handlePostImage($data['featured_image']);
        }

        // Post'u oluştur
        $post = $this->postRepository->create($data);

        // Etiketleri ekle
        if (isset($data['tags'])) {
            $this->manageTags($post->id, $data['tags']);
        }

        return $post;
    }

    public function updatePost($id, array $data)
    {
        // Mevcut postu al
        $post = $this->getPostById($id);

        // Slug güncelle
        $data['slug'] = Str::slug($data['title']);

        // Eğer yeni resim yüklendiyse
        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            // Eski resmi sil
            if ($post->featured_image) {
                $this->removePostImage($post->id);
            }
            // Yeni resmi kaydet
            $data['featured_image'] = $this->handlePostImage($data['featured_image']);
        }

        // Postu güncelle
        $updated = $this->postRepository->update($id, $data);

        // Etiketleri güncelle
        if (isset($data['tags'])) {
            $this->manageTags($id, $data['tags']);
        }

        return $updated;
    }

    public function deletePost($id)
    {
        // Resmi sil
        $this->removePostImage($id);

        // Postu sil
        return $this->postRepository->delete($id);
    }

    public function getPostBySlug($slug)
    {
        return $this->postRepository->findBySlug($slug);
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

    public function removePostImage($postId)
    {
        $post = $this->getPostById($postId);
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
    }

    public function manageTags($postId, array $tagIds)
    {
        $this->postRepository->syncTags($postId, $tagIds);
    }
} 