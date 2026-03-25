<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('site_pages')) {
            return;
        }

        $now = now();

        $pages = [
            [
                'slug' => 'aviso-legal',
                'title' => 'Aviso legal',
                'meta_title' => 'Aviso legal | Greetik',
                'meta_description' => 'Informacion general y condiciones de uso del sitio web segun normativa aplicable.',
                'body' => <<<'HTML'
<p class="text-muted"><em>Borrador de ejemplo: sustituye estos apartados por los datos reales de tu empresa y el texto revisado por tu asesor legal.</em></p>

<h2>1. Datos identificativos</h2>
<p>En cumplimiento del artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico, se informan los siguientes datos:</p>
<ul>
<li><strong>Denominacion social:</strong> [Razon social completa]</li>
<li><strong>NIF/CIF:</strong> [Numero]</li>
<li><strong>Domicilio:</strong> [Direccion completa]</li>
<li><strong>Correo electronico:</strong> [email@ejemplo.com]</li>
<li><strong>Telefono:</strong> [Opcional]</li>
<li><strong>Datos registrales:</strong> [Si procede, registro mercantil / profesional]</li>
</ul>

<h2>2. Objeto</h2>
<p>El presente aviso regula el uso del sitio web [dominio] (en adelante, el "Sitio"). El acceso y uso del Sitio atribuye la condición de usuario e implica la aceptacion de esta informacion.</p>

<h2>3. Propiedad intelectual</h2>
<p>Los contenidos del Sitio (textos, imagenes, diseno, logotipos, etc.) son propiedad de [titular] o de terceros que han autorizado su uso. Queda prohibida su reproduccion o distribucion sin autorizacion.</p>

<h2>4. Responsabilidad</h2>
<p>[Titular] no se responsabiliza del mal uso del Sitio ni del uso de enlaces externos. El usuario es responsable del cumplimiento de la legislacion aplicable.</p>

<h2>5. Legislacion aplicable</h2>
<p>Las relaciones derivadas del uso del Sitio se regiran por la legislacion espanola.</p>
HTML,
                'extra' => null,
                'is_active' => true,
            ],
            [
                'slug' => 'politica-de-privacidad',
                'title' => 'Politica de privacidad',
                'meta_title' => 'Politica de privacidad | Greetik',
                'meta_description' => 'Informacion sobre el tratamiento de datos personales (RGPD y LOPDGDD).',
                'body' => <<<'HTML'
<p class="text-muted"><em>Borrador de ejemplo: adapta cada apartado al responsable del tratamiento, las finalidades reales y las bases juridicas. Recomendable revision juridica.</em></p>

<h2>1. Responsable del tratamiento</h2>
<p><strong>Identidad:</strong> [Razon social] &mdash; <strong>NIF/CIF:</strong> [Numero]<br>
<strong>Direccion:</strong> [Direccion] &mdash; <strong>Correo:</strong> [email contacto privacidad]</p>

<h2>2. Finalidades y bases legales</h2>
<p>Tratamos los datos personales que nos facilites para [finalidades concretas: contacto, gestion comercial, newsletter, etc.], sobre la base de [consentimiento / ejecucion de contrato / interes legitimo, segun proceda].</p>

<h2>3. Conservacion</h2>
<p>Los datos se conservaran durante el tiempo necesario para cumplir la finalidad y los plazos legales aplicables.</p>

<h2>4. Destinatarios</h2>
<p>No cederemos datos a terceros salvo obligacion legal o proveedores que actuen como encargados del tratamiento con el correspondiente contrato.</p>

<h2>5. Derechos</h2>
<p>Puedes ejercer los derechos de acceso, rectificacion, supresion, oposicion, limitacion del tratamiento y portabilidad escribiendo a [email]. Tambien puedes reclamar ante la Agencia Espanola de Proteccion de Datos (<a href="https://www.aepd.es" target="_blank" rel="noopener">www.aepd.es</a>).</p>

<h2>6. Seguridad</h2>
<p>Aplicamos medidas tecnicas y organizativas adecuadas para proteger tus datos.</p>
HTML,
                'extra' => null,
                'is_active' => true,
            ],
            [
                'slug' => 'politica-de-cookies',
                'title' => 'Politica de cookies',
                'meta_title' => 'Politica de cookies | Greetik',
                'meta_description' => 'Informacion sobre el uso de cookies y tecnologias similares en este sitio web.',
                'body' => <<<'HTML'
<p class="text-muted"><em>Borrador de ejemplo: lista las cookies que uses realmente (propias y de terceros), finalidad y duracion. Ajusta el texto al banner/consentimiento que implementes.</em></p>

<h2>1. Que son las cookies</h2>
<p>Las cookies son pequenos archivos que se almacenan en tu dispositivo cuando visitas un sitio web. Tambien pueden usarse tecnologias similares (local storage, pixels, etc.).</p>

<h2>2. Que cookies utilizamos</h2>
<p>[Tabla o lista: nombre, tipo (tecnicas/analiticas/marketing), titular, finalidad, plazo.]</p>

<h2>3. Como gestionar o desactivar cookies</h2>
<p>Puedes configurar tu navegador para rechazar cookies o eliminar las ya instaladas. Ten en cuenta que desactivar cookies tecnicas puede afectar al funcionamiento del Sitio.</p>

<h2>4. Actualizaciones</h2>
<p>Esta politica puede actualizarse. Te recomendamos revisarla periodicamente.</p>
HTML,
                'extra' => null,
                'is_active' => true,
            ],
            [
                'slug' => 'terminos-y-condiciones',
                'title' => 'Terminos y condiciones',
                'meta_title' => 'Terminos y condiciones | Greetik',
                'meta_description' => 'Condiciones generales de uso del sitio web y, si procede, de contratacion.',
                'body' => <<<'HTML'
<p class="text-muted"><em>Borrador de ejemplo: si vendes productos/servicios online, incorpora condiciones de contratacion, precios, plazos, ley aplicable y jurisdiccion. Revision juridica recomendable.</em></p>

<h2>1. Objeto y aceptacion</h2>
<p>Las presentes condiciones regulan el acceso y uso del sitio web [dominio]. El uso del Sitio implica la aceptacion plena de estas condiciones.</p>

<h2>2. Uso permitido</h2>
<p>El usuario se compromete a hacer un uso licito del Sitio, sin vulnerar derechos de terceros ni introducir contenidos ilicitos o malware.</p>

<h2>3. Propiedad intelectual</h2>
<p>Todos los derechos sobre los contenidos del Sitio pertenecen a [titular] o a sus licenciantes, salvo indicacion en contrario.</p>

<h2>4. Limitacion de responsabilidad</h2>
<p>[Titular] no garantiza la disponibilidad ininterrumpida del Sitio. En la medida permitida por la ley, se excluye responsabilidad por danos indirectos derivados del uso del Sitio.</p>

<h2>5. Enlaces</h2>
<p>El Sitio puede contener enlaces a sitios de terceros sobre los que no tenemos control ni responsabilidad.</p>

<h2>6. Modificaciones</h2>
<p>Podemos modificar estas condiciones en cualquier momento. La version vigente sera la publicada en el Sitio.</p>

<h2>7. Legislacion y jurisdiccion</h2>
<p>[Indicar ley aplicable y tribunales competentes, sujeto a normas imperativas del consumidor si aplica.]</p>
HTML,
                'extra' => null,
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            if (DB::table('site_pages')->where('slug', $page['slug'])->exists()) {
                continue;
            }
            DB::table('site_pages')->insert([
                'slug' => $page['slug'],
                'title' => $page['title'],
                'meta_title' => $page['meta_title'],
                'meta_description' => $page['meta_description'],
                'body' => $page['body'],
                'extra' => null,
                'is_active' => $page['is_active'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_pages')) {
            return;
        }

        DB::table('site_pages')->whereIn('slug', [
            'aviso-legal',
            'politica-de-privacidad',
            'politica-de-cookies',
            'terminos-y-condiciones',
        ])->delete();
    }
};
