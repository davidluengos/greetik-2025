<?php

namespace App\Support\PricingTables;

final class PricingPlanView
{
    /**
     * Marca al inicio del texto (tras trim) para filas de «Características».
     * Ej.: "(C) Dominio propio" → característica "Dominio propio".
     */
    private const CHARACTERISTIC_PREFIX_PATTERN = '/^\(C\)\s*/iu';

    /**
     * Prepara un plan del JSON para la vista de producto.
     *
     * - name, price, show_price_from (opcional; por defecto false: sin etiqueta «Desde»),
     *   description, after_features (string o array de strings; párrafos opcionales bajo características),
     *   highlighted, button_*
     * - highlights (opcional): strings extra en el bloque superior (viñetas).
     * - features: mezcla de strings y objetos { "text", "optional" }.
     *   · String que empiece por (C) → característica (se quita el prefijo).
     *   · String sin (C) → bloque superior, junto a highlights.
     *   · Si ningún string del array empieza por (C), todos los strings se tratan
     *     como características (compatibilidad con listas antiguas sin prefijo).
     *   · Objetos → siempre características; optional viene del JSON.
     *
     * @param  array<string, mixed>  $plan
     * @return array{
     *     name: string,
     *     price: string,
     *     show_price_from: bool,
     *     description: ?string,
     *     after_feature_lines: list<string>,
     *     highlight_lines: list<string>,
     *     feature_items: list<array{text: string, optional: bool}>,
     *     highlighted: bool,
     *     button_label: string,
     *     button_url: ?string
     * }
     */
    public static function normalizeForView(array $plan): array
    {
        $name = trim((string) ($plan['name'] ?? '')) ?: 'Plan';
        $price = trim((string) ($plan['price'] ?? '')) ?: '-';

        $showPriceFrom = array_key_exists('show_price_from', $plan) && (bool) $plan['show_price_from'];

        $description = isset($plan['description']) ? trim((string) $plan['description']) : null;
        $description = ($description === '') ? null : $description;

        $afterFeatureLines = self::normalizeAfterFeatures($plan['after_features'] ?? null);

        $rawFeatures = $plan['features'] ?? [];
        if (! is_array($rawFeatures)) {
            $rawFeatures = [];
        }

        $highlightLines = [];
        if (array_key_exists('highlights', $plan) && is_array($plan['highlights'])) {
            foreach ($plan['highlights'] as $line) {
                $s = trim((string) $line);
                if ($s !== '') {
                    $highlightLines[] = $s;
                }
            }
        }

        $anyStringUsesCharacteristicPrefix = false;
        foreach ($rawFeatures as $item) {
            if (is_array($item)) {
                continue;
            }
            $t = trim((string) $item);
            if ($t === '' || mb_strtolower($t, 'UTF-8') === 'características') {
                continue;
            }
            if (self::hasCharacteristicPrefix($t)) {
                $anyStringUsesCharacteristicPrefix = true;
                break;
            }
        }

        $featureItems = [];
        foreach ($rawFeatures as $item) {
            if (is_array($item)) {
                $text = trim((string) ($item['text'] ?? $item['label'] ?? ''));
                if ($text === '') {
                    continue;
                }
                $text = self::stripCharacteristicPrefix($text);
                $optional = ! empty($item['optional']);
                $featureItems[] = ['text' => $text, 'optional' => $optional];

                continue;
            }

            $text = trim((string) $item);
            if ($text === '') {
                continue;
            }

            if (mb_strtolower($text, 'UTF-8') === 'características') {
                continue;
            }

            if ($anyStringUsesCharacteristicPrefix) {
                if (self::hasCharacteristicPrefix($text)) {
                    $body = self::stripCharacteristicPrefix($text);
                    if ($body === '') {
                        continue;
                    }
                    $optional = str_contains(mb_strtolower($body, 'UTF-8'), 'opcional');
                    $clean = $optional
                        ? trim((string) preg_replace('/\s*\(opcional\)\s*/iu', '', $body))
                        : $body;
                    $featureItems[] = ['text' => $clean, 'optional' => $optional];
                } else {
                    $highlightLines[] = $text;
                }

                continue;
            }

            $optional = str_contains(mb_strtolower($text, 'UTF-8'), 'opcional');
            $clean = $optional
                ? trim((string) preg_replace('/\s*\(opcional\)\s*/iu', '', $text))
                : $text;
            $featureItems[] = ['text' => $clean, 'optional' => $optional];
        }

        $buttonUrl = null;
        if (isset($plan['button_url'])) {
            $t = trim((string) $plan['button_url']);
            $buttonUrl = $t !== '' ? $t : null;
        }

        return [
            'name' => $name,
            'price' => $price,
            'show_price_from' => $showPriceFrom,
            'description' => $description,
            'after_feature_lines' => $afterFeatureLines,
            'highlight_lines' => $highlightLines,
            'feature_items' => $featureItems,
            'highlighted' => ! empty($plan['highlighted']),
            'button_label' => trim((string) ($plan['button_label'] ?? '')) ?: 'Solicitar',
            'button_url' => $buttonUrl,
        ];
    }

    /**
     * @return list<string>
     */
    private static function normalizeAfterFeatures(mixed $value): array
    {
        if ($value === null) {
            return [];
        }

        if (is_string($value)) {
            $s = trim($value);

            return $s === '' ? [] : [$s];
        }

        if (! is_array($value)) {
            return [];
        }

        $out = [];
        foreach ($value as $line) {
            $s = trim((string) $line);
            if ($s !== '') {
                $out[] = $s;
            }
        }

        return $out;
    }

    private static function hasCharacteristicPrefix(string $text): bool
    {
        return (bool) preg_match('/^\(C\)/iu', $text);
    }

    private static function stripCharacteristicPrefix(string $text): string
    {
        return trim((string) preg_replace(self::CHARACTERISTIC_PREFIX_PATTERN, '', $text));
    }
}
