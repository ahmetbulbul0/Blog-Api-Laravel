<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $this->route('post')],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string'],
            'publishedAt' => ['nullable', 'date'],
            'categoryId' => ['required', 'exists:categories,id'],
            'userId' => ['required', 'exists:users,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'published_at' => $this->publishedAt,
            'category_id' => $this->categoryId,
            'user_id' => $this->userId
        ]);
    }
}
