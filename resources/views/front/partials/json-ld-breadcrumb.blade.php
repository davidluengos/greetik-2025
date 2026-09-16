{{--
    BreadcrumbList schema. Espera $breadcrumbs = [['name' => '...', 'url' => '...'], ...].
    Se pushea con @push('json_ld') @include(...) @endpush desde cada vista con breadcrumb.
--}}
@php
    $items = [];
    foreach (($breadcrumbs ?? []) as $i => $crumb) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => (string) ($crumb['name'] ?? ''),
            'item' => (string) ($crumb['url'] ?? ''),
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
@endphp
@if ($items !== [])
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>
@endif
