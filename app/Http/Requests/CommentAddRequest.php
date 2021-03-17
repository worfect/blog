<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentAddRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'text.required'  => 'Add a comment text',
            'text.max'  => 'Maximum comment size - 500 characters',
        ];
    }
}
