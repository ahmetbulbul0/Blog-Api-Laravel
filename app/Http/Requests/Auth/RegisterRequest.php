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
            "firstName" => ['required', 'string', 'max:255'],
            "lastName" => ['required', 'string', 'max:255'],
            "username" => ['required', 'string', 'max:255', "unique:users,username"],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'profilePicture' => ['nullable', 'image', 'max:2048'],
            'occupation' => ['required', 'string', 'max:255'],
            'dateOfBirth' => ['required', 'date', 'before:today'],
            'location' => ['required', 'string', 'max:255'],
            'preferredLanguage' => ['required', 'string', 'in:tr,en'],
            'gender' => ['required', 'string', 'in:male,female,other,prefer_not_to_say'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'interests' => ['nullable', 'array'],
            'interests.*' => ['exists:tags,id']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'password_confirmation' => $this->passwordConfirmation,
        ]);
    }
}
