<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PasswordResetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'bail|required',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'  => trans('passwords.code'),
            'password.required'  => trans('passwords.password'),
            'password.min'  => trans('passwords.min'),
            'password.confirmed'  =>  trans('passwords.confirmed'),
        ];
    }
}
