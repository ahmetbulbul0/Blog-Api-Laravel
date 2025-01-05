@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Yeni Blog Yazısı</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Başlık</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">İçerik</label>
                <textarea name="content" id="content" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-700">Özet</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700">Öne Çıkan Görsel</label>
                <input type="file" name="featured_image" id="featured_image" class="mt-1 block w-full">
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Kategori Seçin</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700">Etiketler</label>
                <select name="tags[]" id="tags" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                @error('tags')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Başlık</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('meta_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Açıklama</label>
                <textarea name="meta_description" id="meta_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Meta Anahtar Kelimeler</label>
                <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('meta_keywords')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Durum</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Taslak</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Yayında</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div id="published_at_container" style="display: none;">
                <label for="published_at" class="block text-sm font-medium text-gray-700">Yayın Tarihi</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('published_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('posts.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    İptal
                </a>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const publishedAtContainer = document.getElementById('published_at_container');

        function togglePublishedAt() {
            if (statusSelect.value === 'published') {
                publishedAtContainer.style.display = 'block';
            } else {
                publishedAtContainer.style.display = 'none';
            }
        }

        statusSelect.addEventListener('change', togglePublishedAt);
        togglePublishedAt();
    });
</script>
@endpush
@endsection
