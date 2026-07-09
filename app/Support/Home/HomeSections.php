<?php

namespace App\Support\Home;

final class HomeSections
{
    /**
     * Registro de módulos de la home. El orden aquí es el orden por defecto.
     *
     * key   → identificador estable (partial en front/home-sections/<key>.blade.php).
     * label → nombre mostrado en el admin.
     *
     * @return array<int, array{key: string, label: string}>
     */
    public static function registry(): array
    {
        return [
            ['key' => 'slider', 'label' => 'Slider principal'],
            ['key' => 'featured_products', 'label' => 'Producto destacado'],
            ['key' => 'services', 'label' => 'Nuestros servicios'],
            ['key' => 'testimonials', 'label' => 'Opiniones de clientes'],
            ['key' => 'value_props', 'label' => 'Ventajas de una web'],
            ['key' => 'web_features', 'label' => 'Desarrollo web profesional'],
        ];
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_map(static fn (array $s): string => $s['key'], self::registry());
    }

    /**
     * Configuración por defecto de cada módulo (activo + orden), a partir del registro.
     *
     * @return array<string, array{active: bool, order: int}>
     */
    public static function defaults(): array
    {
        $defaults = [];
        foreach (self::registry() as $i => $section) {
            $defaults[$section['key']] = ['active' => true, 'order' => $i + 1];
        }

        return $defaults;
    }

    /**
     * Fusiona los ajustes guardados en extra['home_sections'] sobre los defaults
     * y devuelve la lista de claves de módulos ACTIVOS, ordenada.
     *
     * @param  array<string, mixed>  $extra
     * @return list<string>
     */
    public static function activeOrderedKeys(array $extra): array
    {
        $config = self::config($extra);

        $active = array_filter($config, static fn (array $c): bool => $c['active']);

        uasort($active, static fn (array $a, array $b): int => $a['order'] <=> $b['order']);

        return array_keys($active);
    }

    /**
     * Configuración completa (todos los módulos, activos o no) fusionando defaults
     * con los overrides de extra['home_sections']. Usada por el formulario del admin.
     *
     * @param  array<string, mixed>  $extra
     * @return array<string, array{active: bool, order: int}>
     */
    public static function config(array $extra): array
    {
        $defaults = self::defaults();
        $saved = isset($extra['home_sections']) && is_array($extra['home_sections'])
            ? $extra['home_sections']
            : [];

        $config = [];
        foreach ($defaults as $key => $default) {
            $override = isset($saved[$key]) && is_array($saved[$key]) ? $saved[$key] : [];

            $config[$key] = [
                'active' => array_key_exists('active', $override)
                    ? (bool) $override['active']
                    : $default['active'],
                'order' => array_key_exists('order', $override)
                    ? (int) $override['order']
                    : $default['order'],
            ];
        }

        return $config;
    }
}
