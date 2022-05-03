<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Controllers\Auth\ProcessingAuthRequests;
use Illuminate\Foundation\Http\FormRequest;

final class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        $prepare = new ProcessingAuthRequests();
        return $prepare->loginRequestProcessing($this->all());
    }


    public function rules(): array
    {
        return [
            'email' => 'sometimes',
            'phone' => 'sometimes',
            'login' => 'sometimes|required|alpha_dash',
            'password' => 'bail|required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required'  => trans('auth.login.no_input'),
            'password.required'  => trans('auth.login.no_input'),
        ];
    }
}
