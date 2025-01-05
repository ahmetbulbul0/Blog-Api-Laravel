@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($post->featured_image)
                <div class="w-full h-96 relative">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-8">
                <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>

                <div class="flex items-center text-gray-600 text-sm mb-6">
                    <span class="mr-4">
                        <i class="fas fa-user mr-1"></i>
                        {{ $post->user->name }}
                    </span>
                    <span class="mr-4">
                        <i class="fas fa-folder mr-1"></i>
                        {{ $post->category->name }}
                    </span>
                    <span class="mr-4">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $post->created_at->format('d.m.Y') }}
                    </span>
                    <span class="mr-4">
                        <i class="fas fa-eye mr-1"></i>
                        {{ $post->views_count }} görüntülenme
                    </span>
                    <span>
                        <i class="fas fa-comment mr-1"></i>
                        {{ $post->comments_count }} yorum
                    </span>
                </div>

                @if($post->excerpt)
                    <div class="text-lg text-gray-600 mb-6">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($post->content)) !!}
                </div>

                @if($post->tags->count() > 0)
                    <div class="flex items-center space-x-2 mb-6">
                        <span class="text-gray-600">
                            <i class="fas fa-tags mr-2"></i>
                        </span>
                        @foreach($post->tags as $tag)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                @if(auth()->user()->can('update', $post) || auth()->user()->can('delete', $post))
                    <div class="flex justify-end space-x-4 border-t pt-4">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit mr-1"></i>
                                Düzenle
                            </a>
                        @endcan
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
                                    <i class="fas fa-trash mr-1"></i>
                                    Sil
                                </button>
                            </form>
                        @endcan
                    </div>
                @endif
            </div>
        </article>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Yorumlar ({{ $post->comments->count() }})</h2>

            @foreach($post->comments as $comment)
                <div class="bg-white rounded-lg shadow-lg p-6 mb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-semibold">
                                {{ $comment->user ? $comment->user->name : $comment->guest_name }}
                            </h3>
                            <span class="text-sm text-gray-600">
                                {{ $comment->created_at->format('d.m.Y H:i') }}
                            </span>
                        </div>
                        @if(auth()->user()->can('update', $comment) || auth()->user()->can('delete', $comment))
                            <div class="flex space-x-2">
                                @can('update', $comment)
                                    <button class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endcan
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Bu yorumu silmek istediğinizden emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>

                @foreach($comment->replies as $reply)
                    <div class="ml-8 bg-white rounded-lg shadow-lg p-6 mb-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold">
                                    {{ $reply->user ? $reply->user->name : $reply->guest_name }}
                                </h3>
                                <span class="text-sm text-gray-600">
                                    {{ $reply->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            @if(auth()->user()->can('update', $reply) || auth()->user()->can('delete', $reply))
                                <div class="flex space-x-2">
                                    @can('update', $reply)
                                        <button class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endcan
                                    @can('delete', $reply)
                                        <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Bu yorumu silmek istediğinizden emin misiniz?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-700">{{ $reply->content }}</p>
                    </div>
                @endforeach
            @endforeach

            @auth
                <form action="{{ route('comments.store') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Yorum Yaz</label>
                        <textarea name="content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Yorum Gönder
                        </button>
                    </div>
                </form>
            @else
                <div class="mt-6 bg-gray-100 rounded-lg p-6">
                    <p class="text-center text-gray-600">
                        Yorum yapabilmek için lütfen <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700">giriş yapın</a> veya <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700">kayıt olun</a>.
                    </p>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
