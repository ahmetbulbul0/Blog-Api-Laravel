@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Blog Yazıları</h1>
        @can('create', App\Models\Post::class)
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Yeni Yazı
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-500">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt ?? $post->content, 150) }}</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="mr-2">{{ $post->user->name }}</span>
                            <span>{{ $post->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-4">
                                <i class="fas fa-eye mr-1"></i>
                                {{ $post->views_count }}
                            </span>
                            <span>
                                <i class="fas fa-comment mr-1"></i>
                                {{ $post->comments_count }}
                            </span>
                        </div>
                    </div>
                    @if(auth()->user()->can('update', $post) || auth()->user()->can('delete', $post))
                        <div class="mt-4 flex justify-end space-x-2">
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i> Düzenle
                                </a>
                            @endcan
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
                                        <i class="fas fa-trash"></i> Sil
                                    </button>
                                </form>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>
@endsection
