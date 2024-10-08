<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' =>  'string|email|max:255|unique:users',
            'password' => [Password::min(8)->mixedCase()->numbers()->symbols()],
            'repeated_password' => 'same:password',
            'user_type_id' => 'integer|exists:user_types,id',
        ];
    }
}
