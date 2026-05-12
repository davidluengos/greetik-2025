<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1', 'max:25'],
            'files.*' => ['file', 'max:15360', 'mimes:jpeg,jpg,png,gif,webp,svg,mp4,webm,ogg,mp3,wav'],
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Selecciona al menos un archivo.',
            'files.*.mimes' => 'Formato no permitido. Usa imagen, vídeo o audio habituales.',
            'files.*.max' => 'Cada archivo puede pesar como máximo 15 MB.',
        ];
    }
}
