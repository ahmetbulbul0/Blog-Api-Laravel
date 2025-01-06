<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,' . $this->route('tag')],
            'slug' => ['required', 'string', 'max:255', 'unique:tags,slug,' . $this->route('tag')]
        ];
    }
}
