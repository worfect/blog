<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ImageAddRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|bail|string|max:50',
            'text' => 'nullable|bail|string',
            'image' => 'required|image|max:10240',
            'categories' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'  => 'Image not added',
            'image.image'  => 'File must be an image (jpeg, png, bmp, gif, svg, or webp)',
            'image.max'  => 'Image size exceeds 10MB',
            'categories.array'  => 'Invalid format',
        ];
    }
}
