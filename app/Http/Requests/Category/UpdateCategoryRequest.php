<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,'.$this->route('category').',id'],
            'description' => ['nullable', 'string'],
            'parentId' => ['nullable', 'exists:categories,id']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'parent_id' => $this->parentId
        ]);
    }
}
