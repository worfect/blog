<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Controllers\Auth\ProcessingAuthRequests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UserDataUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        $prepare = new ProcessingAuthRequests();

        return $prepare->userDataUpdateProcessing($this->all());
    }

    public function rules(): array
    {
        return [
            'email' => [Rule::requiredIf(function () {
                $user = User::where('id', $this['id'])->first();
                return $user->hasEmail();
            }),
                        Rule::unique('users')->ignore($this['id']),
            ],
            'phone' => [Rule::requiredIf(function () {
                $user = User::where('id', $this['id'])->first();
                return $user->hasPhone();
            }),
                        Rule::unique('users')->ignore($this['id']),
            ],
            'screen_name' => ['required', 'between:3,30', 'alpha_dash', Rule::unique('users')->ignore($this['id'])],
        ];
    }

    public function messages(): array
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
