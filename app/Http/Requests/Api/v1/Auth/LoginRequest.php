<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Http\Requests\Base\BaseFormRequest;

class LoginRequest extends BaseFormRequest
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
            'email' => ['required', 'email', 'min:3', 'max:255'],
            'password' => ['required', 'string', 'min:1', 'max:255'],
            'remember' => ['nullable', 'boolean'],
        ];
    }
}
