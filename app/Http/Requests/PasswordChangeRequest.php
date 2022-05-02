<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|current_password',
            'new_password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'new_password.required'  => trans('passwords.password'),
            'new_password.min'  => trans('passwords.min'),
            'new_password.confirmed'  =>  trans('passwords.confirmed')
        ];
    }
}
