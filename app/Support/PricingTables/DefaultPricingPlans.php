<?php

namespace App\Support\PricingTables;

class DefaultPricingPlans
{
    public static function get(): array
    {
        return [
            [
                'name' => 'Light',
                'price' => '20 EUR',
                'show_price_from' => true,
                'description' => 'Perfecto para comenzar.',
                'features' => [
                    'SSL incluido',
                    'Responsive',
                    '(C) Landing page',
                    '(C) Formulario de contacto',
                    '(C) Soporte por email',
                ],
                'highlighted' => false,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
            [
                'name' => 'Run',
                'price' => '50 EUR',
                'show_price_from' => true,
                'description' => 'Ideal para negocios en crecimiento.',
                'features' => [
                    '(C) Web corporativa',
                    '(C) Blog',
                    '(C) SEO basico',
                    '(C) Mantenimiento mensual (opcional)',
                ],
                'after_features' => [
                    'Los precios no incluyen IVA.',
                    'Consulta condiciones de permanencia y activación.',
                ],
                'highlighted' => true,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
            [
                'name' => 'Fly',
                'price' => '100 EUR',
                'description' => 'Para proyectos con necesidades avanzadas.',
                'features' => [
                    '(C) Todo lo anterior',
                    '(C) Integraciones',
                    '(C) Prioridad soporte',
                ],
                'highlighted' => false,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
        ];
    }
}
