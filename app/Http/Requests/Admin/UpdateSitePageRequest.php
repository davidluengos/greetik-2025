<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSitePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $sitePage = $this->route('site_page');

        if ($sitePage?->slug === 'contacto') {
            $this->merge([
                'product_form_id' => $this->filled('product_form_id') ? $this->integer('product_form_id') : null,
            ]);
        }

        if ($sitePage?->slug === 'home') {
            $color = trim((string) $this->input('hero_background_color', ''));
            $this->merge([
                'hero_background_color' => $color === '' ? null : $color,
            ]);
        }
    }

    public function rules(): array
    {
        $sitePage = $this->route('site_page');

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'address_title' => ['nullable', 'string', 'max:120'],
            'address' => ['nullable', 'string'],
            'hours_title' => ['nullable', 'string', 'max:120'],
            'hours' => ['nullable', 'string'],
            'phones_title' => ['nullable', 'string', 'max:120'],
            'phones_text' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'form_heading' => ['nullable', 'string', 'max:255'],
            'map_embed' => ['nullable', 'string'],
            'product_form_id' => ['nullable', 'integer', Rule::exists('product_forms', 'id')],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'carousel_json' => ['nullable', 'string'],
        ];

        if ($sitePage?->slug === 'home') {
            $rules['hero_title'] = ['nullable', 'string', 'max:255'];
            $rules['hero_subtitle'] = ['nullable', 'string', 'max:255'];
            $rules['hero_text'] = ['nullable', 'string', 'max:2000'];
            $rules['hero_background_image'] = ['nullable', 'string', 'max:255'];
            $rules['hero_background_image_file'] = ['nullable', 'image', 'max:5120'];
            $rules['hero_background_color'] = [
                'nullable',
                'string',
                'max:12',
                'regex:/^#(?:[\da-fA-F]{3}|[\da-fA-F]{6}|[\da-fA-F]{8})$/',
            ];
            $rules['clear_hero_background_image'] = ['sometimes', 'boolean'];
            $rules['hero_primary_cta_text'] = ['nullable', 'string', 'max:120'];
            $rules['hero_primary_cta_url'] = ['nullable', 'string', 'max:500'];
            $rules['hero_secondary_cta_text'] = ['nullable', 'string', 'max:120'];
            $rules['hero_secondary_cta_url'] = ['nullable', 'string', 'max:500'];
        }

        return $rules;
    }
}
