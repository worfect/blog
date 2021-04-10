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
            'login.required'  => 'Enter your login, email or phone',
            'login.alpha_dash'  => 'Invalid characters used',
            'password.required'  => 'Enter password',
            'password.string'  => 'Password must be a string',
        ];
    }

}
