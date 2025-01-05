<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->post);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'], // 2MB max
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable', 'date', 'required_if:status,published']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Başlık alanı zorunludur.',
            'title.max' => 'Başlık en fazla 255 karakter olabilir.',
            'content.required' => 'İçerik alanı zorunludur.',
            'featured_image.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'featured_image.max' => 'Resim dosyası en fazla 2MB olabilir.',
            'category_id.required' => 'Kategori seçimi zorunludur.',
            'category_id.exists' => 'Seçilen kategori geçerli değil.',
            'tags.*.exists' => 'Seçilen etiketlerden bazıları geçerli değil.',
            'meta_title.max' => 'Meta başlık en fazla 60 karakter olabilir.',
            'meta_description.max' => 'Meta açıklama en fazla 160 karakter olabilir.',
            'status.required' => 'Durum alanı zorunludur.',
            'status.in' => 'Geçersiz durum değeri.',
            'published_at.required_if' => 'Yayın tarihi, yayınlanacak yazılar için zorunludur.'
        ];
    }
}
