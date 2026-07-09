<?php

namespace App\Support\Home;

final class DefaultValueProps
{
    public const TITLE = 'Creemos en las plataformas web como una ayuda para optimizar los recursos de su empresa';

    /**
     * Ventajas de una aplicación web. Cada item: icon (FontAwesome), title, text.
     *
     * @return list<array{icon: string, title: string, text: string}>
     */
    public static function get(): array
    {
        return [
            [
                'icon' => 'fa fa-clock-o',
                'title' => 'Disponible 24 horas',
                'text' => 'Una aplicación web siempre está operativa, cada vez que la necesite.',
            ],
            [
                'icon' => 'fa fa-cloud',
                'title' => 'Sin instalaciones',
                'text' => 'La información se almacena en la nube y se accede desde cualquier navegador.',
            ],
            [
                'icon' => 'fa fa-mobile',
                'title' => 'Diseño responsive',
                'text' => 'Las aplicaciones son multiplataforma, adaptadas a todo tipo de dispositivos.',
            ],
            [
                'icon' => 'fa fa-lock',
                'title' => 'Datos seguros',
                'text' => 'Nuestros servidores operan con certificados de seguridad SSL.',
            ],
            [
                'icon' => 'fa fa-line-chart',
                'title' => 'Mejora continua',
                'text' => 'Avanzamos y mejoramos la plataforma a medida que tus necesidades van creciendo.',
            ],
            [
                'icon' => 'fa fa-magic',
                'title' => 'Fácil e intuitivo',
                'text' => 'Con un diseño moderno e intuitivo, para optimizar el tiempo y los recursos.',
            ],
        ];
    }
}
