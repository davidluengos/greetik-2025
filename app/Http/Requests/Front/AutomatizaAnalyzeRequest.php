<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AutomatizaAnalyzeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sector' => ['required', Rule::in(array_keys((array) config('automatiza.sectors', [])))],
            'sector_other' => ['nullable', 'string', 'max:120'],
            'company_size' => ['required', Rule::in(array_keys((array) config('automatiza.company_sizes', [])))],

            'tools' => ['required', 'array', 'min:1'],
            'tools.*' => [Rule::in(array_keys((array) config('automatiza.tools', [])))],

            'repetitive_hours' => ['required', Rule::in(array_keys((array) config('automatiza.repetitive_hours', [])))],
            'customer_management' => ['required', Rule::in(array_keys((array) config('automatiza.customer_management', [])))],
            'quotations' => ['required', Rule::in(array_keys((array) config('automatiza.quotations', [])))],
            'follow_up' => ['required', Rule::in(array_keys((array) config('automatiza.follow_up', [])))],

            'documents' => ['nullable', 'array'],
            'documents.*' => [Rule::in(array_keys((array) config('automatiza.documents', [])))],

            'communication' => ['nullable', 'array'],
            'communication.*' => [Rule::in(array_keys((array) config('automatiza.communication', [])))],

            'main_problem' => ['nullable', 'string', 'max:2000'],
            'hourly_cost' => ['required', Rule::in(array_keys((array) config('automatiza.hourly_costs', [])))],

            // Honeypot + rate-limit temporal (mismo patron que el resto del sitio).
            'website' => ['nullable', 'string', 'max:0'],
            'form_started_at' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'sector.required' => 'Selecciona a qué se dedica tu empresa.',
            'company_size.required' => 'Indica cuántas personas trabajan en la empresa.',
            'tools.required' => 'Selecciona al menos una herramienta.',
            'repetitive_hours.required' => 'Indica cuánto tiempo dedicáis a tareas repetitivas.',
            'customer_management.required' => 'Indica cómo gestionáis clientes y contactos.',
            'quotations.required' => 'Indica cómo preparáis presupuestos.',
            'follow_up.required' => 'Indica si os cuesta hacer seguimiento.',
            'hourly_cost.required' => 'Indica el coste/hora aproximado.',
        ];
    }
}
