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
                'description' => 'Perfecto para comenzar.',
                'features' => ['Landing page', 'Formulario de contacto', 'Soporte por email'],
                'highlighted' => false,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
            [
                'name' => 'Run',
                'price' => '50 EUR',
                'description' => 'Ideal para negocios en crecimiento.',
                'features' => ['Web corporativa', 'Blog', 'SEO basico'],
                'highlighted' => true,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
            [
                'name' => 'Fly',
                'price' => '100 EUR',
                'description' => 'Para proyectos con necesidades avanzadas.',
                'features' => ['Todo lo anterior', 'Integraciones', 'Prioridad soporte'],
                'highlighted' => false,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
        ];
    }
}
