<?php

namespace App\Support\ProductForms;

final class TemplateRenderer
{
    /**
     * Sustituye variables tipo {{ token }} en una plantilla.
     *
     * @param  array<string, string>  $tokens
     * @param  bool  $escapeHtml  escapa los valores (para cuerpos HTML donde
     *                            el valor proviene de datos del usuario).
     */
    public static function render(string $template, array $tokens, bool $escapeHtml = false): string
    {
        return (string) preg_replace_callback(
            '/\{\{\s*([\w.\-]+)\s*\}\}/u',
            static function (array $m) use ($tokens, $escapeHtml): string {
                $value = (string) ($tokens[$m[1]] ?? '');

                return $escapeHtml ? e($value) : $value;
            },
            $template
        );
    }
}
