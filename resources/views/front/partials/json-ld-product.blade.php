{{--
    Product schema. Espera $project (App\Models\Project).
    Se pushea con @push('json_ld') @include(...) @endpush desde producto.blade.php.
--}}
@php
    $imageUrl = filled($project->image)
        ? asset($project->image)
        : \App\Support\SiteBranding::defaultOgImage();

    $description = filled($project->excerpt)
        ? $project->excerpt
        : \App\Support\SiteBranding::defaultDescription();

    // Google exige offers/review/aggregateRating para validar Product como rich result.
    // Precio minimo entre los planes del pricing table activo. Prioridad:
    //   1. plan['price_from_amount'] (numerico) — usarlo si esta poblado. Sirve para
    //      indicar el minimo efectivo (ej. 2€/user × 5 users min = 10€) sin depender
    //      del string libre que ve el humano.
    //   2. Primer numero parseado de plan['price'] (string). Fallback cuando no hay
    //      valor estructurado.
    // Sin pricing activo o sin planes con precio parseable, no emitimos offers.
    $offers = null;
    $pricing = $project->pricingTable;
    if ($pricing && $pricing->is_active && is_array($pricing->plans)) {
        $prices = [];
        foreach ($pricing->plans as $plan) {
            if (! is_array($plan)) {
                continue;
            }
            if (isset($plan['price_from_amount']) && is_numeric($plan['price_from_amount'])) {
                $num = (float) $plan['price_from_amount'];
            } elseif (preg_match('/(\d+(?:[.,]\d+)?)/', (string) ($plan['price'] ?? ''), $m)) {
                $num = (float) str_replace(',', '.', $m[1]);
            } else {
                continue;
            }
            if ($num > 0) {
                $prices[] = $num;
            }
        }
        if ($prices !== []) {
            $offers = [
                '@type' => 'Offer',
                'price' => number_format(min($prices), 2, '.', ''),
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'url' => url()->current(),
            ];
        }
    }

    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $project->title,
        'description' => $description,
        'image' => $imageUrl,
        'url' => url()->current(),
        'brand' => [
            '@type' => 'Brand',
            'name' => \App\Support\SiteBranding::siteName(),
        ],
    ];

    if ($offers !== null) {
        $productSchema['offers'] = $offers;
    }
@endphp
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>
