<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:255'],
            'metatitle' => ['nullable', 'string', 'max:255'],
            'metadescription' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'publishdate' => ['nullable', 'date'],
            'enddate' => ['nullable', 'date', 'after_or_equal:publishdate'],
            'extra' => ['nullable', 'string'],
        ];
    }
}
