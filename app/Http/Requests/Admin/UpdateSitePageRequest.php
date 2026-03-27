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
    }

    public function rules(): array
    {
        return [
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
            'form_heading' => ['nullable', 'string', 'max:255'],
            'map_embed' => ['nullable', 'string'],
            'product_form_id' => ['nullable', 'integer', Rule::exists('product_forms', 'id')],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'carousel_json' => ['nullable', 'string'],
        ];
    }
}
