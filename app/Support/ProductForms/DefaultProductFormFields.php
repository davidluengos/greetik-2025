<?php

namespace App\Support\ProductForms;

class DefaultProductFormFields
{
    public static function get(): array
    {
        return [
            ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'required' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ['name' => 'phone', 'label' => 'Telefono', 'type' => 'text', 'required' => false],
            ['name' => 'message', 'label' => 'Mensaje', 'type' => 'textarea', 'required' => true],
        ];
    }
}
