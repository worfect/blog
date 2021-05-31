<?php

namespace App\Http\Requests;

use App\Http\Controllers\Auth\ProcessingAuthRequests;
use Illuminate\Foundation\Http\FormRequest;


class UserRegistrationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        $prepare = new ProcessingAuthRequests();
        return $prepare->registerRequestProcessing($this->all());

    }


    public function rules()
    {
        return [
            'uniqueness' => 'sometimes|accepted',
            'email' => 'sometimes|unique:users',
            'phone' => 'sometimes|unique:users',
            'login' => 'bail|required|string|between:3,30|unique:users|alpha_dash',
            'password' => 'bail|required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'uniqueness.accepted' => trans('auth.register.accepted'),
            'email.unique'  => trans('auth.register.email.unique'),
            'phone.unique'  => trans('auth.register.phone.unique'),
            'login.required'  => trans('auth.register.login.required'),
            'login.between'  => trans('auth.register.login.between'),
            'login.unique'  => trans('auth.register.login.unique'),
            'login.alpha_dash'  => trans('auth.register.login.alpha_dash'),
            'password.required'  => trans('auth.register.password.required'),
            'password.min'  => trans('auth.register.password.min'),
            'password.confirmed'  => trans('auth.register.password.confirmed'),
        ];
    }
}
