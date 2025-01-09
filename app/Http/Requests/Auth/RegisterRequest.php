<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'occupation' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'location' => ['required', 'string', 'max:255'],
            'preferred_language' => ['required', 'string', 'in:tr,en'],
            'gender' => ['required', 'string', 'in:male,female,other,prefer_not_to_say'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'interests' => ['required', 'array', 'min:1'],
            'interests.*' => ['exists:tags,id']
        ];
    }
}
