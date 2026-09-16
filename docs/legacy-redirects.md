# Redirects 301 desde URLs legacy `/secciones/{slug}-{id}`

Sistema para recuperar el SEO de URLs indexadas por Google del CMS anterior, que hoy caerian a 404 nativo de Laravel.

## Patron capturado

Toda peticion a `/secciones/{cualquier-cosa}-{id}` donde `{id}` es un entero al final del path. Ruta definida en `routes/web.php`:

```php
Route::get('/secciones/{path}', [LegacyRedirectController::class, 'handle'])
    ->where('path', '.+')
    ->name('legacy.section');
```

`{path}` acepta cualquier subruta con al menos 1 caracter. `/secciones/` a secas cae al 404 estandar.

## Orden de resolucion

`LegacyRedirectController@handle` resuelve en este orden:

1. **Extrae el `-{id}` del final del path.** Si no hay digitos al final → **410 Gone** (URL invalida).
2. **Busca `config('legacy_redirects.{id}')`.** Si existe y resuelve a un destino valido → **301** a esa URL.
3. **Auto-fallback a blog:** si `Post::find($oldId)` existe **Y** el slug del path antiguo comparte >= 50% de tokens con el slug actual del post → **301** a `/post/{slug}-{id}`. El check de tokens protege de colisiones (ver mas abajo).
4. **Nada de lo anterior** → **410 Gone** (`resources/views/errors/410.blade.php`) + log en canal por defecto.

**Regla practica:**

- Si la URL antigua ERA un blog post → cae sola por el paso 3, no hace falta anadirla al config.
- Si NO era un blog post (producto, seccion estatica, portfolio index, servicio...) → tienes que añadirla al config o cae a 410.

### Por que el check de slug

Los section_id del CMS antiguo eran globales (una seccion con id 40 podia ser un proyecto), y el `post.id` actual no correlaciona 1:1 con esos section_id. Ejemplo real: section 40 era MyTrainik, y `post.id=40` existe pero es un post distinto sin relacion.

Sin el check, `/secciones/mytrainik-...-40` sin mapping caeria a `/post/{slug-del-post-40}-40` — redirect al post equivocado, peor para Google que un 410.

Con el check: los tokens del path (`[mytrainik, software, ...]`) no comparten >= 50% con los del post 40 (`[titulo, del, post, cualquiera]`) → falla el fallback → **410 limpio**. Si viera tráfico real, se anade al config y a la vez.

Umbral configurable en `LegacyRedirectController::POST_SLUG_MATCH_MIN_RATIO`.

## Formato del config

`config/legacy_redirects.php`:

```php
return [
    14 => ['type' => 'project',   'id' => 2],                     // Item: producto Reservik
    42 => ['type' => 'portfolio', 'id' => 5],                     // Item: portfolio item id 5
    9  => ['type' => 'route',     'name' => 'contacto'],          // Estatica: /contacto
    26 => ['type' => 'route',     'name' => 'portfolio.index'],   // Estatica: /portfolio (indice)
    99 => ['type' => 'url',       'url'  => '/cualquier-cosa'],   // Escape: URL hardcoded
];
```

Tipos aceptados:

| type         | Campos requeridos      | Resuelve a                                              | Aguanta cambio de slug/URL |
|--------------|------------------------|---------------------------------------------------------|----------------------------|
| `project`    | `id`                   | `route('productos.show', $project->slug)`               | Sí                         |
| `post`       | `id`                   | `/post/{Str::slug($post->title)}-{id}`                  | Sí                         |
| `portfolio`  | `id`                   | `route('portfolio.show', $item->slug)`                  | Sí                         |
| `route`      | `name` (route name)    | `route($name)` — para paginas estaticas por nombre      | Sí                         |
| `url`        | `url` (string)         | Redirect directo a esa URL. Escape para casos raros.    | **No** (URL hardcoded)     |

**Todo lo que no sea `type: url` se resuelve al vuelo en tiempo de request.** Cambies el slug del producto o renombres la URL de `/contacto`, los 301 siguen apuntando al sitio correcto sin editar este fichero.

**Cuando `type: portfolio` no es lo que quieres:** `portfolio` es para un item INDIVIDUAL. Si la URL antigua correspondia a la pagina indice `/portfolio`, usa `['type' => 'route', 'name' => 'portfolio.index']`. Mismo caso para servicios (`servicios.index`), blog (`posts.index`), home (`home`), sobre-nosotros (`about`), automatiza (`automatiza.landing`).

### Nombres de ruta validos actualmente

Para paginas estaticas:

- `home` → `/`
- `contacto` → `/contacto`
- `about` → `/sobre-nosotros`
- `portfolio.index` → `/portfolio`
- `servicios.index` → `/servicios`
- `posts.index` → `/blog`
- `automatiza.landing` → `/automatiza`

Si el nombre no existe, el controller registra el miss y responde 410.

## Anadir entradas

Fuente canonica: **informe de Rendimiento de Google Search Console** (ultimos 16 meses), filtrado por URLs `/secciones/*` con clics historicos.

Para cada URL top:
1. Extraer el `{id}` del final del path.
2. Identificar a que entidad actual corresponde (Project, Post, PortfolioItem).
3. Anadir entrada al array de `config/legacy_redirects.php`.
4. Commit + deploy.

Si una URL no tiene entidad equivalente (contenido descontinuado), se puede usar `['type' => 'url', 'url' => '/servicios']` para redirigirla a la seccion mas cercana en vez de dejarla 410.

## 302 → 301 en `PostController@show`

Cuando alguien accede a `/post/{slug-erroneo}-{id}` con un slug distinto al canonico, `PostController@show` redirige al canonico. Antes emitia **302** (temporal), lo que no consolidaba autoridad en Google. Ahora emite **301** (permanente).

## Testing manual

```bash
# 1. Auto-fallback: post existente + slug matcheando (>=50% tokens) → 301
curl -sI http://127.0.0.1/secciones/nueva-web-2 | grep -Ei "HTTP|Location"
# Debe responder: 301 + Location: /post/nueva-web-2

# 2. Config wins: id colisiona con post pero mapping explicito manda → 301 al mapping
curl -sI http://127.0.0.1/secciones/mytrainik---software-online-de-gestion-para-entrenador-personal-40
# Debe responder: 301 + Location: /productos/{slug-actual-de-mytrainik}

# 3. Slug-safety: id coincide con post pero slug NO matchea → 410
curl -sI http://127.0.0.1/secciones/algo-2 | grep -Ei "HTTP"
# Debe responder: 410 (no redirige al post 2 aunque exista)

# 4. Path sin ID al final → 410 Gone
curl -sI http://127.0.0.1/secciones/no-tiene-numero | grep -Ei "HTTP"
# Debe responder: 410

# 5. Fix del 302 → 301 en PostController
curl -sI http://127.0.0.1/post/slug-mal-2 | grep -Ei "HTTP|Location"
# Debe responder: 301 (no 302) + Location al slug canonico
```

## Observabilidad

Los miss (no-id-in-path + no-mapping) se loguean en el canal `logging.default` como `legacy_redirect.miss` con contexto:

```json
{"path": "algo-99999", "reason": "no-mapping", "old_id": 99999}
```

Utilizable con `tail -f storage/logs/laravel.log | grep legacy_redirect` en produccion para ver que URLs se estan pidiendo y aun no estan mapeadas.

## Redirect catch-all para `/tag/*` (sistema de tags legacy)

El CMS antiguo tenia un sistema de tags que generaba URLs como `/tag/Laravel`, `/tag/MyTrainik/2` (paginacion), `/tag/Compras%20Online`. En la migracion a Laravel no se replico el sistema y las ~50 URLs indexadas por Google caian a 404 nativo.

Solucion (2026-09-16): route catch-all en `routes/web.php` que 301 a `/blog`:

```php
Route::get('/tag/{tag}', fn () => redirect('/blog', 301))
    ->where('tag', '.+')
    ->name('legacy.tag');
```

Consolida autoridad de dominio a `/blog` pero perdemos la especificidad por tag. Decision pragmatica porque el vocabulario de tags del CMS antiguo era mayoritariamente ruido (`hotmail`, `anime`, `2019`, `Actualidad Greetik`, etc.). Si en el futuro se implementa un sistema de tags real (modelo Tag + many-to-many con Post), sustituir este catch-all por la ruta granular.

## Ficheros implicados

| Fichero | Rol |
|---------|-----|
| `routes/web.php` | Registro de la ruta |
| `app/Http/Controllers/Front/LegacyRedirectController.php` | Logica de resolucion |
| `config/legacy_redirects.php` | Mapa estatico de entradas |
| `resources/views/errors/410.blade.php` | Vista amigable de 410 Gone |
| `app/Http/Controllers/Front/PostController.php` | Fix 302 → 301 en canonical redirect |
