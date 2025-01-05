<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft'
        ];

        $post = Post::create($postData);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Test Post'
        ]);
    }

    public function test_post_generates_slug(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'title' => 'Test Post Title',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft'
        ]);

        $this->assertEquals('test-post-title', $post->slug);
    }

    public function test_post_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft'
        ]);

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    public function test_post_belongs_to_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft'
        ]);

        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
    }

    public function test_post_can_have_tags(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft'
        ]);

        $post->tags()->attach($tag);

        $this->assertTrue($post->tags->contains($tag));
    }

    public function test_post_can_have_comments(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft'
        ]);

        $comment = Comment::create([
            'content' => 'Test Comment',
            'post_id' => $post->id,
            'user_id' => $user->id
        ]);

        $this->assertTrue($post->comments->contains($comment));
    }

    public function test_can_track_post_views(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'published'
        ]);

        $post->views()->create([
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test Agent',
            'viewed_at' => now()
        ]);

        $this->assertEquals(1, $post->views()->count());
    }
}
