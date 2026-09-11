<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AutomatizaLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'privacy' => ['accepted'],
            'website' => ['nullable', 'string', 'max:0'],
            'form_started_at' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Indica tu nombre.',
            'email.required' => 'Indica un email de contacto.',
            'email.email' => 'El email no parece válido.',
            'privacy.accepted' => 'Debes aceptar la política de privacidad.',
        ];
    }
}
