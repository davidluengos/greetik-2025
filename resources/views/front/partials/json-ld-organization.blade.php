{{-- Organization schema (sitewide). Se emite en el <head> del layout base. --}}
@php
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => \App\Support\SiteBranding::siteName(),
        'url' => url('/'),
        'logo' => \App\Support\SiteBranding::defaultOgImage(),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($organizationSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>
