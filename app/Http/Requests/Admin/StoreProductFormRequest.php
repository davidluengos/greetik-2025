<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'intro' => ['nullable', 'string'],
            'action_url' => ['nullable', 'string', 'max:500'],
            'button_label' => ['nullable', 'string', 'max:120'],
            'fields' => ['nullable', 'json'],
        ];
    }
}
