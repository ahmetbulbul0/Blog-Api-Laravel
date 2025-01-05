<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $posts = Post::with(['user', 'category', 'tags'])
            ->withCount(['comments', 'views'])
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post = Post::create($data);

        if (isset($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Blog yazısı başarıyla oluşturuldu.');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category', 'tags', 'comments' => function ($query) {
            $query->approved()->whereNull('parent_id');
        }]);

        if (!auth()->user() || auth()->id() !== $post->user_id) {
            $post->views()->create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
                'viewed_at' => now()
            ]);
        }

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Blog yazısı başarıyla güncellendi.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Blog yazısı başarıyla silindi.');
    }
}
