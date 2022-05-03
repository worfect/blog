<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ImageUpdateRequest extends FormRequest
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
            'categories' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'categories.array'  => 'Invalid format',
        ];
    }
}
