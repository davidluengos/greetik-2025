# Slots SEO del layout front

Convencion para que cada vista pueda sobrescribir meta tags y datos estructurados de forma limpia. Vive en `resources/views/front/layouts/app.blade.php`.

## Slots disponibles

Todos son `@yield` con default. Se sobrescriben con `@section('nombre', 'valor')` en la vista.

| Slot | Default | Cuando sobrescribir |
|------|---------|---------------------|
| `title` | `SiteBranding::pageTitle('Inicio')` | Siempre — cada vista debe poner su titulo |
| `meta_description` | `SiteBranding::defaultDescription()` | Vistas con `excerpt` propio (post, producto, servicio, etc.) |
| `canonical` | `url()->current()` | Solo si la URL canonica es distinta de la actual (rara vez) |
| `og_type` | `website` | `article` en posts de blog, `product` en productos |
| `og_title` | `SiteBranding::siteName()` | Todas las vistas de contenido |
| `og_description` | `SiteBranding::defaultDescription()` | Igual que meta_description (mismo valor) |
| `og_url` | `url()->current()` | Solo si es distinta de la actual |
| `og_image` | `SiteBranding::defaultOgImage()` | Vistas de entidades con imagen propia (producto, post, portfolio) |
| `twitter_card` | `summary_large_image` | Solo si necesitas otro tipo (`summary`, `player`, etc.) |
| `twitter_title` | `SiteBranding::siteName()` | Igual que og_title |
| `twitter_description` | `SiteBranding::defaultDescription()` | Igual que og_description |
| `twitter_image` | `SiteBranding::defaultOgImage()` | Igual que og_image |

Un slot condicional (solo se emite si la vista lo define):

| Slot | Ejemplo de valor | Cuando |
|------|------------------|--------|
| `robots` | `noindex,follow` | Paginas transaccionales (wizard, resultado, previews). Por defecto NO se emite el `<meta name="robots">` — los crawlers asumen `index,follow`. |

Ademas un stack:

| Stack | Uso |
|-------|-----|
| `json_ld` | Push de `<script type="application/ld+json">` (Product, FAQPage, BreadcrumbList, etc.). El layout ya emite `Organization` sitewide antes del stack — las vistas solo pushean lo especifico. |

## Partials JSON-LD disponibles

| Partial | Uso | Espera |
|---------|-----|--------|
| `front.partials.json-ld-organization` | Automatico en layout (sitewide). No hace falta incluirlo desde vistas. | — |
| `front.partials.json-ld-product` | `@include` via `@push('json_ld')` en `producto.blade.php` | `$project` (App\Models\Project) |
| `front.partials.json-ld-breadcrumb` | `@include` via `@push('json_ld')` en cualquier vista con breadcrumb | `$breadcrumbs` = array de `['name' => ..., 'url' => ...]` |

### Gotcha con `@context` de schema.org

Blade en Laravel 11+ interpreta `@context` como directiva del sistema de contexto (`context()->has(...)`). Si escribes `@context` inline dentro de `{!! json_encode([...]) !!}` sale corrupto con codigo PHP compilado dentro del JSON. **Solucion**: construir el array dentro de un bloque `@php ... @endphp` y hacer `json_encode` sobre la variable. Todos los partials siguen ese patron.

## Como sobrescribir en una vista

```blade
@extends('front.layouts.app')

@section('title', \App\Support\SiteBranding::pageTitle($post->metatitle ?: $post->title))
@section('meta_description', $post->metadescription ?: Str::limit(strip_tags($post->body), 155))
@section('og_type', 'article')
@section('og_title', $post->title)
@section('og_description', $post->metadescription ?: Str::limit(strip_tags($post->body), 155))
@section('og_image', $post->image ? asset($post->image) : \App\Support\SiteBranding::defaultOgImage())

@push('json_ld')
    <script type="application/ld+json">
    { "@context": "https://schema.org", "@type": "Article", ... }
    </script>
@endpush

@section('content')
    ...
@endsection
```

## Valores por defecto

`App\Support\SiteBranding` centraliza los defaults site-wide:

- `defaultDescription()` — texto generico Greetik. Editable desde `site_pages.home.extra.site_description` (admin).
- `defaultOgImage()` — `public/front/img/parallax-slider/images/greetik-soluciones.png`. Editable desde `site_pages.home.extra.site_og_image`.
- `siteName()` — de `config('app.name')`, fallback `"Greetik"`.

Para cambiar defaults site-wide sin tocar codigo: editar la pagina `home` del admin y anadir claves a `extra`. Para cambiar por vista: `@section('...')`.

## OG image: buenas practicas

- Dimensiones: 1200 × 630 px (proporcion 1.91:1).
- Formato: PNG o JPG (< 5 MB).
- **URL absoluta obligatoria.** `asset()` la genera automatica.
- Contenido visible en el thumbnail: logo + una frase corta o el screenshot del producto.

## Vistas ya migradas al sistema de slots

Al cerrar Fase 0 tarea 4 (2026-09-15):

- `producto.blade.php`
- `post.blade.php` (con decode de HTML entities + normalizacion de whitespace para el fallback de body)
- `portfolio-item.blade.php`
- `servicios.blade.php` (descripcion hardcodeada, no hay $page)
- `sobre-nosotros.blade.php`, `contacto.blade.php`, `legal-page.blade.php` (via `$page` SitePage con `meta_title` y `meta_description` editables desde admin)
- `automatiza/index.blade.php`, `wizard.blade.php`, `resultado.blade.php`, `sector.blade.php` (migradas de `@push('styles')` a `@section` — `wizard` y `resultado` usan `@section('robots', 'noindex,follow')`)

Pendientes (fuera de scope de tarea 4, todas con defaults del layout que ya son razonables): `home.blade.php`, `posts.blade.php` (listado blog), `portfolio.blade.php` (listado).
