<?php

namespace App\Http\Requests;

use App\Http\Controllers\Auth\ProcessingAuthRequests;
use Illuminate\Foundation\Http\FormRequest;


class UserLoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        $prepare = new ProcessingAuthRequests();
        return $prepare->loginRequestProcessing($this->all());
    }


    public function rules()
    {
        return [
            'email' => 'sometimes',
            'phone' => 'sometimes',
            'login' => 'sometimes|required|alpha_dash',
            'password' => 'bail|required|string',
        ];
    }

    public function messages()
    {
        return [
            'login.required'  => trans('auth.login.no_input'),
            'password.required'  => trans('auth.login.no_input'),
        ];
    }
}
