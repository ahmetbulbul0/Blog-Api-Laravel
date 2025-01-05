<?php

namespace App\Http\Requests\PostView;

use Illuminate\Foundation\Http\FormRequest;

class StorePostViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
            'ip_address' => 'nullable|ip',
            'user_agent' => 'nullable|string|max:255'
        ];
    }
}
