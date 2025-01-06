<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'postId' => ['required', 'exists:posts,id'],
            'userId' => ['required', 'exists:users,id'],
            'parentId' => ['nullable', 'exists:comments,id']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'post_id' => $this->postId,
            'user_id' => $this->userId,
            'parent_id' => $this->parentId
        ]);
    }
}
