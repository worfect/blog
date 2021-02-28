<?php

namespace App\Http\Requests;

use App\Http\Controllers\Helpers\ProcessingAuthRequests;
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
            'uniqueness.accepted' => 'Enter the correct email or phone number',
            'email.unique'  => 'This email is already in use',
            'phone.unique'  => 'This phone is already in use',
            'login.required'  => 'Enter login',
            'login.string'  => 'Login must be a string',
            'login.between'  => 'Login length - from 3 to 30 characters',
            'login.unique'  => 'This login is already in use',
            'login.alpha_dash'  => 'Field may have alpha-numeric characters, as well as dashes and underscores',
            'password.required'  => 'Enter password',
            'password.string'  => 'Password must be a string',
            'password.min'  => 'Min password length - 6 characters',
            'password.confirmed'  => 'Confirmed password',
        ];
    }
}
