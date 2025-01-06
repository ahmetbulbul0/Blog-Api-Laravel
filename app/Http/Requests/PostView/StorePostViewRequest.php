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
            'user_id' => 'nullable|exists:users,id',
            'ip_address' => 'required|ip',
            'user_agent' => 'required|string'
        ];
    }
}
