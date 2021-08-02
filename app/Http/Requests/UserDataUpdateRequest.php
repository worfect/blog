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
            'screen_name' => ['required', 'between:3,30', 'alpha_dash', Rule::unique('users')->ignore($this['id'])],
        ];
    }

    public function messages()
    {
        return [
            'email.required'  => trans('auth.update.email.required'),
            'email.unique'  => trans('auth.update.email.unique'),

            'phone.required'  => trans('auth.update.phone.required'),
            'phone.unique'  => trans('auth.update.phone.unique'),

            'screen_name.required'  => trans('auth.update.screen_name.required'),
            'screen_name.alpha_dash'  => trans('auth.update.screen_name.alpha_dash'),
            'screen_name.between'  => trans('auth.update.screen_name.between'),
            'screen_name.unique'  => trans('auth.update.screen_name.unique'),
        ];
    }
}
