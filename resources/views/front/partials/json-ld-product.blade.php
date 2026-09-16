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
@endphp
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>
