<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PasswordChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'required|current_password',
            'new_password' => 'required|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.required'  => trans('passwords.password'),
            'new_password.min'  => trans('passwords.min'),
            'new_password.confirmed'  =>  trans('passwords.confirmed'),
        ];
    }
}
