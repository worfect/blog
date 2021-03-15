<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|bail|string|max:50',
            'text' => 'nullable|bail|string',
            'categories' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'categories.array'  => 'Invalid format',
        ];
    }
}
