<?php

namespace App\Http\Requests;

use App\Http\Controllers\Auth\ProcessingAuthRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserDataUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        $prepare = new ProcessingAuthRequests();

        return $prepare->userDataUpdateProcessing($this->all());
    }


    public function rules()
    {
        return [
            'email' => ['required', Rule::unique('users')->ignore($this['id'])],
            'phone' => ['required', Rule::unique('users')->ignore($this['id'])],
            'screen_name' => 'required|alpha_dash',
        ];
    }

    public function messages()
    {
        return [
            'email.required'  => trans('auth.update.email.required'),
            'phone.required'  => trans('auth.update.phone.required'),
            'screen_name.required'  => trans('auth.update.screen_name.required'),

            'screen_name.alpha_dash'  => trans('auth.update.screen_name.alpha_dash'),

            'phone.unique'  => trans('auth.update.phone.unique'),
            'email.unique'  => trans('auth.update.email.unique'),
        ];
    }
}
