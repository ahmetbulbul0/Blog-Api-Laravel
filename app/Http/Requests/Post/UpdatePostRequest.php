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
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $this->route('post')],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => ['required', 'exists:users,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id']
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
