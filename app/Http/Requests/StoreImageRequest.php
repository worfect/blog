<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreImageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|bail|string|between:3,50|alpha_dash',
            'text' => 'nullable|bail|string|min:3|alpha_dash',
            'image' => 'required|image|max:10240',
            'categories' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'image.required'  => 'Image not added',
            'image.image'  => 'File must be an image (jpeg, png, bmp, gif, svg, or webp)',
            'image.max'  => 'Image size exceeds 10MB',
            'categories.array'  => 'Invalid format',
        ];
    }
}
