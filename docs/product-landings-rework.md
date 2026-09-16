# Rework de landings de producto + recuperacion SEO

Documento vivo del trabajo iniciado en 2026-09 para:

1. **Recuperar el SEO** perdido tras la migracion del CMS anterior a Laravel (Fase 0).
2. **Sustituir el body HTML libre** de los productos por un sistema de bloques tipados que escale a nuevos productos (Fase 1+).

Los dos objetivos son independientes, pero se abordan en el mismo tramo porque comparten el mismo espacio de codigo (`resources/views/front/producto.blade.php` + modelo `Project`).

---

## 📍 Retomar aqui (ultima parada 2026-09-15)

**Estado Fase 0:** 5 tareas cerradas, 4 abiertas.

| Estado | Task |
|--------|------|
| ✅ | #2 slots SEO en layout front |
| ✅ | #3 meta tags en producto.blade.php |
| ✅ | #4 meta tags en resto de vistas + migracion Automatiza |
| ✅ | #6 JSON-LD Organization + Product + BreadcrumbList |
| ✅ | #7 legacy redirects `/secciones/{path}` (**ya commiteada** en `7c7579d`) |
| ⏳ | #1 auditoria GSC (usuario) |
| ⏳ | #5 poblar `Project.image` en MyTrainik/Reservik (usuario) |
| ⏳ | #8 anadir mas entradas a `config/legacy_redirects.php` desde GSC |
| ⏳ | #9 reindex GSC post-deploy |

**Trabajo en local sin commit** (14 modified + 4 untracked). Cubre tareas 2, 3, 4 y 6. Ultimo commit en `main`: `7c7579d` (solo tarea 7).

**Siguiente accion concreta al reanudar:**

1. Preparar commit agrupado de tareas 2, 3, 4, 6 con mensaje descriptivo.
2. Push a `origin/main`.
3. Ejecutar checklist de deploy prod (`git pull` + `config:clear` + `view:clear` + smoke test curl + GSC reindex).

**Deploy checklist completo** fue enviado en conversacion del 2026-09-15, incluye: 5 curl smoke tests, acciones en Search Console (verificar sitemap, solicitar indexacion de URLs top, Rich Results Test) y rollback plan (git revert, sin migraciones DB).

**Post-deploy:** avanzar con GSC audit (tarea 1) para completar el mapa de redirects (tarea 8), y coordinar con usuario la subida de OG images para tarea 5. Cuando Fase 0 este validada en prod, arrancamos Fase 1 (motor de bloques tipados + hero end-to-end).

---

---

## Contexto

### Que hay hoy en produccion

- Productos como `App\Models\Project` con `body` (HTML libre editado con TinyMCE) + relacion opcional a `PricingTable` y `ProductForm`.
- Ruta publica `GET /productos/{slug}` → `SeccionesController@showProducto` → `resources/views/front/producto.blade.php`.
- HTML del `body` en Bootstrap 3 legacy (`.thumbnail`, `.clients-comments`, `wow fadeInDown`, etc.).
- 2 productos actuales: MyTrainik (id 1) y Reservik (id 2). ReservaLavadero pendiente de crear.

### Problemas identificados

**SEO tecnico:**
- `producto.blade.php` no emite meta description, canonical, OG/Twitter, ni JSON-LD.
- `Project.image` esta NULL en los 2 productos → sin OG image.
- Layout base `front/layouts/app.blade.php` no expone slots para meta tags (`@yield`/`@stack`).
- URLs antiguas del CMS anterior tenian el patron `/secciones/{slug}-{id}` y hoy caen a 404 nativo (sin redirects 301).
- El unico redirect existente (`PostController@show`) era 302, no consolida en Google.

**Contenido:**
- Landings de producto = intro keyword-stuffed + 9 features en grid 3x3 + prosa H2 densa + CTA con telefono. Formato ~2500-3000 palabras. Rankeaba bien en la web antigua, pero visualmente esta desfasado.
- Sin hero moderno, ni reason-to-buy destacado arriba, ni FAQ estructurado, ni sublandings sector.
- El sistema `PricingTable` no es una tabla de planes real: 1 solo plan, mezcla value props con features reales. En la practica el pricing es escalar (per pista / per usuario / per lavadero).

---

## Decisiones tomadas

### Estrategicas

- **Prioridad 1 = fundamentos SEO.** Sin canonical, meta description, OG, JSON-LD y redirects 301 desde URLs antiguas, cualquier redisenio es cosmetico. Se aborda en la Fase 0 antes de tocar el sistema de bloques.
- **Keyword territory distinto por producto** (para no canibalizarse en SERP):
  - Reservik → "software de reservas para instalaciones deportivas".
  - ReservaLavadero → "software de reservas para lavaderos de coches".
  - MyTrainik → "software para entrenadores personales" (nunca "reservas" en su H1).
- **Sublandings por sector/caso de uso** son el jugo SEO real (fase 4). Reservik por deporte, ReservaLavadero por tipo de lavadero, MyTrainik por caso de uso.
- **CTA doble** en toda landing:
  - Primario "Probar gratis" → `{website_url}` (SaaS externo, `_blank`).
  - Secundario "Hablar con nosotros" → `{contact_url}` = `route('contacto', ['producto' => slug])`.

### Arquitectonicas

- **No Filament**, no admin panel paralelo. Se extiende el admin custom actual (`/gw-admin`, SB Admin 2). Alpine.js repeater sobre el form existente.
- **CSS scoped `.gtk-block-*`** en un unico `public/front/css/product-blocks.css`, no Tailwind global ni Bootstrap 5 (ambos romperian el layout legacy). Precedente validado: `resources/views/front/automatiza/index.blade.php` con `.aut-scope` + `automatiza.css`.
- **Sistema hibrido icono/imagen** en bloques con visuales: cada item declara `visual_type: icon|image`. `icon` es una clase Font Awesome 6 (ya cargado). `image` abre el media library ya existente.
- **Fuera `ProductForm`.** `ContactMessage` ya tiene `form_name` + `source_url` + `data` (JSON) → segmentacion de leads sin modelo dedicado. Phase-out gradual: modelo vivo mientras haya landings legacy sin migrar.
- **Fuera `PricingTable`** como modelo separado. Reemplazo por un bloque `pricing_block` con tres modos: `calculator` (per unidad, caso Reservik / MyTrainik / ReservaLavadero), `tiers` (planes reales), `single` (precio unico). Phase-out gradual igual que `ProductForm`.
- **Placeholders reservados en cualquier campo URL:**
  - `{website_url}` → `$project->website_url`.
  - `{contact_url}` → `route('contacto', ['producto' => $project->slug])`.

### Datos y almacenamiento

- Columna nueva `projects.sections` (JSON nullable). Mientras este vacia se cae al `body` legacy.
- Cada seccion es un objeto `{ id, type, anchor?, is_active, data }`. Orden explicito por posicion en el array. `type` valida contra el `BlockRegistry`.

---

## Fases

### Fase 0 — Fundamentos SEO (en curso)

Recuperar visibilidad. Nada del sistema de bloques empieza hasta que Fase 0 este desplegada.

| # | Tarea | Estado |
|---|-------|--------|
| 1 | Auditar cobertura SEO en GSC (informe Rendimiento + no indexadas + 404) | pending (usuario) |
| 2 | Slots SEO en layout front (meta description, canonical, OG, Twitter, JSON-LD stack) | **completada 2026-09-15** |
| 3 | Rellenar meta tags en `producto.blade.php` | **completada 2026-09-15** |
| 4 | Rellenar meta tags en post/portfolio/servicios/legal | **completada 2026-09-15** |
| 5 | Poblar `Project.image` en MyTrainik y Reservik | pending (usuario) |
| 6 | JSON-LD `Product` + `Organization` + `BreadcrumbList` | **completada 2026-09-15** |
| 7 | Route + controller de 301 para `/secciones/{path}` | **completada 2026-09-15** |
| 8 | Mapa manual de redirects para productos/servicios/portfolio (config file) | pending (necesita GSC) |
| 9 | Post-deploy: reenviar sitemap en GSC + solicitar reindex | pending (usuario) |

Ver [`docs/legacy-redirects.md`](legacy-redirects.md) para la documentacion tecnica del sistema de redirects.

### Fase 1 — Motor de bloques + primer bloque end-to-end

- Migracion `projects.sections` JSON.
- `producto.blade.php` renderiza `sections` si esta poblada, cae al `body` en caso contrario.
- `BlockRegistry` + clase base `Block` (`type()`, `rules()`, `defaults()`, `label()`, `partial()`).
- Editor Alpine.js repeater en `_form.blade.php`.
- Primer bloque completo end-to-end: `hero`. Sirve como plantilla para el resto.

### Fase 2 — Resto de la libreria de bloques

Libreria definitiva (8 bloques):

1. `hero`
2. `guarantee_strip`
3. `feature_grid`
4. `feature_deep` (el bloque SEO estrella, reutilizable N veces)
5. `use_cases`
6. `pricing_block` (modos: `calculator`, `tiers`, `single`)
7. `faq` (+ FAQPage JSON-LD auto)
8. `cta_band`

Esquema de campos detallado por bloque: pendiente de mover a `docs/block-schema.md` cuando arranquemos Fase 1.

### Fase 3 — Backfill de MyTrainik y Reservik

Reconstruir las landings actuales con el sistema de bloques, preservando texto SEO y H2s existentes (Google los tiene indexados).

### Fase 4 — Sublandings por sector

Reservik por deporte, ReservaLavadero por tipo de lavadero, MyTrainik por caso de uso. Multiplica URLs long-tail sin duplicar sistema.

### Fase 5 — Cleanup

Drop de `pricing_tables` + `product_forms` y sus admin sections cuando los productos legacy esten migrados.

---

## Fuera de scope (por ahora)

- Bloque `contact_form` inline en landing (por ahora CTAs a `/contacto`). Se anadira si medimos que la conversion cae por el clic extra.
- Bloque `testimonials` (sin contenido real que meter).
- Preview live en el editor admin (guardar + abrir en pestana aparte es suficiente para MVP).
- Migracion de `pricing` y `form` a bloques propios (Fase 4).
- Cambio de framework CSS global (Tailwind / Bootstrap 5): rompe layout legacy sin ganancia inmediata.

---

## Log de cambios en este doc

- **2026-09-15** — creacion. Fase 0 tarea 7 (legacy redirects) completada. Resto pending.
- **2026-09-15** — quitado auto-fallback a `Post::find` en el controller de legacy redirects. Los section_id del CMS antiguo no correlacionan 1:1 con `post.id`: una seccion 40 podia ser un proyecto, no un post. Ahora *todas* las URLs (incluidos posts) requieren mapeo explicito en `config/legacy_redirects.php`. Ver [`legacy-redirects.md`](legacy-redirects.md).
- **2026-09-15** — reintroducido el auto-fallback a blog, esta vez con salvaguarda de slug (>= 50% tokens en comun entre path antiguo y slug actual del post). Motivacion: el 90% de las URLs legacy son posts y forzarlas todas al config era demasiado tedioso. El slug-check protege del bug de la colision section 40 = MyTrainik: si el usuario olvida mapear una seccion no-post, en vez de wrong-redirect al post que casualmente comparte id, cae a 410 limpio. Umbral configurable via `LegacyRedirectController::POST_SLUG_MATCH_MIN_RATIO`.
- **2026-09-15** — Fase 0 tarea 2 (slots SEO en layout) completada. `front/layouts/app.blade.php` expone `@yield` para meta description, canonical, OG (type/title/description/url/image/site_name) y Twitter Card, mas un `@stack('json_ld')`. `SiteBranding` gana `defaultDescription()` y `defaultOgImage()` con fallback editable desde `site_pages.home.extra`. Ver [`seo-slots.md`](seo-slots.md). Sabor secundario: Automatiza sigue emitiendo tags via `@push('styles')` — duplicados temporales hasta que tarea 4 la migre.
- **2026-09-15** — Fase 0 tarea 3 (meta tags en producto.blade.php) completada. `producto.blade.php` precalcula `$displayTitle` (pricing title si activa, si no project title), `$seoDescription` (excerpt del project, fallback a `SiteBranding::defaultDescription()`), `$ogImage` (`asset($project->image)`, fallback a `defaultOgImage()`) y los inyecta a los slots via `@section`. Canonical se resuelve solo con `url()->current()`. Cuando tarea 5 pueble `Project.image` de MyTrainik/Reservik, la og image dejara de caer al default global.
- **2026-09-15** — Fase 0 tarea 4 (meta tags en resto de vistas) completada. Migradas: `post` (con decode de HTML entities en fallback de body), `portfolio-item`, `servicios` (hardcoded), `sobre-nosotros`, `contacto`, `legal-page` (todas leyendo `SitePage.meta_title`/`meta_description`), y las 4 vistas de Automatiza (`index`, `wizard`, `resultado`, `sector`) migradas de `@push('styles')` a `@section` — eliminados los duplicados que habia. Layout gana slot condicional `robots` para `noindex,follow` de wizard/resultado. Ver [`seo-slots.md`](seo-slots.md) para lista final.
- **2026-09-15** — Fase 0 tarea 6 (JSON-LD) completada. Tres partials en `resources/views/front/partials/json-ld-*.blade.php`: `Organization` (auto sitewide desde el layout), `Product` (push desde `producto.blade.php`), `BreadcrumbList` (push desde vistas con breadcrumb). Producto emite los 3 bloques verificado con curl. Pending para tareas posteriores: `Article` en `post.blade.php`, `FAQPage` auto desde el futuro bloque `faq`, `WebPage`/`CreativeWork` en portfolio-item. Gotcha documentado en [`seo-slots.md`](seo-slots.md): `@context` inline dentro de `{!! json_encode([...]) !!}` corrompe el JSON porque Blade lo compila como directiva del sistema de contexto de Laravel 11+; hay que construir el array en `@php...@endphp`.
