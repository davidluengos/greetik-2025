<?php

/*
 * Mapa de URLs legacy /secciones/{slug}-{id} → destino nuevo.
 *
 * Clave: {id} numérico del final del path antiguo (section_id del CMS anterior).
 * Valor: mapping al recurso actual. El slug se resuelve al vuelo desde el modelo,
 *        de manera que aguanta cambios futuros de slug sin tocar este fichero.
 *
 * Formas admitidas:
 *   ['type' => 'project',   'id' => 2]      → route('productos.show', $project->slug)
 *   ['type' => 'post',      'id' => 42]     → /post/{slug}-{id}
 *   ['type' => 'portfolio', 'id' => 7]      → route('portfolio.show', $item->slug)
 *   ['type' => 'url',       'url' => '/x']  → 301 directo a una URL cualquiera
 *
 * Orden de resolución en LegacyRedirectController:
 *   1. Mapeo explícito en este fichero → 301 al destino resuelto.
 *   2. Auto-fallback a blog: si Post::find({id}) existe Y el slug del path
 *      antiguo comparte >=50% de tokens con el slug actual del post → 301
 *      a /post/{slug}-{id}. El check de slug protege de colisiones (ej. section 40
 *      = MyTrainik, mientras post.id=40 tambien existe con otro contenido).
 *   3. Sin match → 410 Gone.
 *
 * Regla practica: si una URL antigua ERA un blog post → cae sola por el paso 2,
 * no hace falta añadirla aquí. Si NO era un blog post (producto, seccion estatica,
 * portfolio index...) → tienes que añadirla aquí explícitamente o cae a 410.
 *
 * Añadir entradas: normalmente desde el informe de Rendimiento de GSC (top URLs con clics
 * históricos que hoy devuelven 410 o 404). Cada entrada = un commit.
 */

return [
    // MyTrainik: /secciones/mytrainik---software-online-de-gestion-para-entrenador-personal-40
    40 => ['type' => 'project', 'id' => 1],
    // Reservik: /secciones/reservik---software-de-reservas-de-padel-online-14
    14 => ['type' => 'project', 'id' => 2],
    // Portfolio: /secciones/portfolio-26
    26 => ['type' => 'url', 'url' => '/portfolio'],
    // Blog: /secciones/blog-8
    8 => ['type' => 'url', 'url' => '/blog'],
    // Contacto: /secciones/contacto-9
    9 => ['type' => 'url', 'url' => '/contacto'],
    // Acerca de: /secciones/sobre-nosotros-6
    6 => ['type' => 'url', 'url' => '/sobre-nosotros'],
    // Política de privacidad: /secciones/politica-de-privacidad-12
    12 => ['type' => 'url', 'url' => '/politica-de-privacidad'],
    // Términos y condiciones: /secciones/terminos-y-condiciones-de-nuestros-servicios-23
    23 => ['type' => 'url', 'url' => '/terminos-y-condiciones'],
    // Servicios: /secciones/servicios-7
    7 => ['type' => 'url', 'url' => '/servicios'],
    // Desarrollo de software a medida: /secciones/desarrollo-de-software-a-medida-30 → ancla Aplicaciones web
    30 => ['type' => 'url', 'url' => '/servicios#servicio-aplicaciones-web'],
    // Tiendas online: /secciones/tiendas-online-29 → ancla Tiendas online
    29 => ['type' => 'url', 'url' => '/servicios#servicio-tiendas-online'],
    // Diseño web: /secciones/diseno-web-28 → ancla Webs corporativas
    28 => ['type' => 'url', 'url' => '/servicios#servicio-webs-corporativas'],
    // Consultoría TIC: /secciones/consultoria-tic-37 → sin equivalente, cae al listado general
    37 => ['type' => 'url', 'url' => '/servicios'],
    // Diseño gráfico: /secciones/diseno-grafico-38 → ancla Diseño gráfico
    38 => ['type' => 'url', 'url' => '/servicios#servicio-diseno-grafico'],
];
