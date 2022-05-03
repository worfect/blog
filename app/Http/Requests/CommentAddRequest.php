<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CommentAddRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'text.required'  => 'Add a comment text',
            'text.max'  => 'Maximum comment size - 500 characters',
        ];
    }
}
