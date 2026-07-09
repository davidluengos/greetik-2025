<?php

namespace App\Support\ProductForms;

class DefaultProductFormFields
{
    public static function get(): array
    {
        return [
            ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'required' => true, 'placeholder' => 'Tu nombre y apellidos'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true, 'placeholder' => 'nombre@tu-empresa.com'],
            ['name' => 'phone', 'label' => 'Teléfono', 'type' => 'text', 'required' => false, 'placeholder' => 'Para poder llamarte (opcional)'],
            ['name' => 'message', 'label' => 'Mensaje', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Cuéntanos brevemente qué necesitas: tipo de proyecto, objetivos, plazos o cualquier duda. Cuanto más nos cuentes, mejor podremos ayudarte.'],
        ];
    }
}
