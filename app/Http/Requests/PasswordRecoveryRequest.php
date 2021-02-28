<?php

namespace App\Http\Requests;

use App\Http\Controllers\Helpers\ProcessingAuthRequests;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRecoveryRequest extends FormRequest
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

    public function validationData()
    {
        $prepare = new ProcessingAuthRequests();
        return $prepare->passwordRecoveryProcessing($this->all());
    }

    public function rules()
    {
        return [
            'email' => 'sometimes',
            'phone' => 'sometimes',
            'login' => 'sometimes|required|alpha_dash',
        ];
    }

    public function messages()
    {
        return [
            'login.required'  => 'Enter your login, email or phone',
            'login.alpha_dash'  => 'Invalid characters used',
        ];
    }
}
