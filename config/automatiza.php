<?php

/*
 |----------------------------------------------------------------------
 | Configuración de la herramienta "Greetik Automatiza"
 |----------------------------------------------------------------------
 |
 | Este archivo concentra todo lo que puede evolucionar sin tocar
 | código: sectores, tamaños de empresa, procesos analizables,
 | tipos de solución, rangos de inversión orientativos y contenido
 | de las páginas sectoriales de SEO.
 |
 */

return [

    // Valor razonable de coste/hora cuando el usuario dice "No lo sé".
    'default_hourly_cost' => 20,

    // Peso máximo del score (para normalizar a 0-100).
    'score_max_raw' => 20,

    // Umbrales del nivel de automatización (0-100).
    'score_levels' => [
        ['max' => 25, 'key' => 'bajo', 'label' => 'Bajo'],
        ['max' => 50, 'key' => 'inicial', 'label' => 'Inicial'],
        ['max' => 75, 'key' => 'medio', 'label' => 'Medio'],
        ['max' => 100, 'key' => 'alto', 'label' => 'Alto potencial'],
    ],

    // Sectores mostrados en el wizard (paso 1). Ampliable sin tocar código.
    'sectors' => [
        'construccion' => 'Construcción',
        'servicios_profesionales' => 'Servicios profesionales',
        'comercio' => 'Comercio',
        'hosteleria' => 'Hostelería',
        'inmobiliaria' => 'Inmobiliaria',
        'salud_bienestar' => 'Salud / bienestar',
        'formacion' => 'Formación',
        'gimnasios' => 'Gimnasios / centros deportivos',
        'mantenimiento' => 'Mantenimiento / instalaciones',
        'marketing' => 'Agencia / marketing',
        'otro' => 'Otro',
    ],

    // Tamaños de empresa. La clave se guarda en BD; el valor es la etiqueta.
    'company_sizes' => [
        'solo' => 'Solo yo',
        '2_5' => '2-5',
        '6_10' => '6-10',
        '11_25' => '11-25',
        '26_50' => '26-50',
        '50_plus' => 'Más de 50',
    ],

    // Herramientas actuales (multi-select del paso 3).
    'tools' => [
        'excel' => 'Excel / Google Sheets',
        'whatsapp' => 'WhatsApp',
        'email' => 'Email',
        'papel' => 'Papel',
        'programa_gestion' => 'Programa de gestión',
        'crm' => 'CRM',
        'erp' => 'ERP',
        'app_propia' => 'Aplicación propia',
        'varias' => 'Varias herramientas independientes',
        'otro' => 'Otro',
    ],

    // Horas semanales dedicadas a tareas repetitivas (paso 4).
    // 'hours' = horas usadas para el cálculo económico.
    // 'saving_ratio' = porcentaje conservador ahorrable de esas horas.
    'repetitive_hours' => [
        'lt_2' => ['label' => 'Menos de 2 horas', 'hours' => 1.5, 'saving_ratio' => 0.35],
        '2_5' => ['label' => '2-5 horas', 'hours' => 3.5, 'saving_ratio' => 0.40],
        '5_10' => ['label' => '5-10 horas', 'hours' => 7.5, 'saving_ratio' => 0.45],
        '10_20' => ['label' => '10-20 horas', 'hours' => 15, 'saving_ratio' => 0.50],
        'gt_20' => ['label' => 'Más de 20 horas', 'hours' => 25, 'saving_ratio' => 0.55],
        'unknown' => ['label' => 'No lo sé', 'hours' => 6, 'saving_ratio' => 0.40, 'estimate' => true],
    ],

    // Paso 5: gestión de clientes.
    'customer_management' => [
        'movil' => 'Agenda / contactos del móvil',
        'excel' => 'Excel / Sheets',
        'email' => 'Email',
        'crm' => 'CRM',
        'programa' => 'Programa específico',
        'ninguno' => 'No tenemos un sistema definido',
    ],

    // Paso 6: presupuestos.
    'quotations' => [
        'word_excel' => 'Word / Excel',
        'plantillas' => 'Plantillas',
        'programa_gestion' => 'Programa de gestión',
        'software_especifico' => 'Software específico',
        'manual' => 'Se hacen manualmente',
        'ninguno' => 'No hacemos presupuestos',
    ],

    // Paso 7: dificultad de seguimiento.
    'follow_up' => [
        'mucho' => 'Mucho',
        'bastante' => 'Bastante',
        'aveces' => 'A veces',
        'poco' => 'Poco',
        'no' => 'No',
    ],

    // Paso 8: documentos repetitivos (multi-select).
    'documents' => [
        'presupuestos' => 'Presupuestos',
        'facturas' => 'Facturas',
        'contratos' => 'Contratos',
        'informes' => 'Informes',
        'partes' => 'Partes de trabajo',
        'albaranes' => 'Albaranes',
        'certificados' => 'Certificados',
        'emails' => 'Emails',
        'otros' => 'Otros',
        'ninguno' => 'Ninguno',
    ],

    // Paso 9: en qué se pierde tiempo (multi-select).
    'communication' => [
        'duplicidad' => 'Introducir datos varias veces',
        'buscar' => 'Buscar información',
        'whatsapp' => 'WhatsApp / llamadas',
        'emails' => 'Emails',
        'documentos' => 'Preparar documentos',
        'seguimiento' => 'Seguimiento de clientes',
        'organizacion' => 'Organización de trabajos',
        'empleados' => 'Recopilar información de empleados',
        'entre_programas' => 'Pasar información de un programa a otro',
        'otro' => 'Otro',
    ],

    // Paso 11: coste/hora. 'unknown' usa default_hourly_cost.
    'hourly_costs' => [
        '10' => ['label' => '10 €', 'value' => 10],
        '15' => ['label' => '15 €', 'value' => 15],
        '20' => ['label' => '20 €', 'value' => 20],
        '25' => ['label' => '25 €', 'value' => 25],
        '30' => ['label' => '30 €', 'value' => 30],
        '40' => ['label' => '40 €', 'value' => 40],
        '40_plus' => ['label' => 'Más de 40 €', 'value' => 50],
        'unknown' => ['label' => 'No lo sé', 'value' => 20, 'estimate' => true],
    ],

    /*
     |------------------------------------------------------------------
     | Matriz de procesos automatizables
     |------------------------------------------------------------------
     |
     | Cada proceso define cómo se puntúa (qué respuestas del wizard
     | disparan puntos) y qué solución típica se recomienda. La suma
     | ordenada nos da los 3 procesos prioritarios del informe.
     |
     */
    'processes' => [
        'customer_management' => [
            'title' => 'Gestión de clientes',
            'reason' => 'Un sistema centralizado permite tener la ficha del cliente, el historial y los próximos pasos en un único sitio.',
            'solution' => 'CRM ligero personalizado o integración con un CRM existente.',
            'triggers' => [
                'customer_management' => ['movil' => 4, 'excel' => 3, 'email' => 3, 'ninguno' => 5, 'crm' => 0, 'programa' => 1],
                'communication' => ['seguimiento' => 3, 'buscar' => 2, 'duplicidad' => 2],
            ],
        ],
        'quotations' => [
            'title' => 'Presupuestos',
            'reason' => 'Preparar presupuestos manualmente se automatiza con plantillas dinámicas, cálculo automático y generación de documentos.',
            'solution' => 'Generador de presupuestos web con plantillas y firma digital.',
            'triggers' => [
                'quotations' => ['word_excel' => 4, 'manual' => 5, 'plantillas' => 2, 'programa_gestion' => 1, 'software_especifico' => 0],
                'documents' => ['presupuestos' => 3],
                'communication' => ['documentos' => 2],
            ],
        ],
        'documents' => [
            'title' => 'Generación de documentos',
            'reason' => 'Si repites informes, contratos o certificados, se pueden generar automáticamente a partir de plantillas y datos ya existentes.',
            'solution' => 'Motor de plantillas + exportación PDF conectado a tu base de datos.',
            'triggers' => [
                'documents' => ['contratos' => 3, 'informes' => 3, 'certificados' => 3, 'albaranes' => 2, 'otros' => 1],
                'communication' => ['documentos' => 2, 'duplicidad' => 2],
            ],
        ],
        'follow_up' => [
            'title' => 'Seguimiento de clientes y oportunidades',
            'reason' => 'Un sistema con recordatorios y estados automatiza el seguimiento y evita perder oportunidades.',
            'solution' => 'Panel de seguimiento con recordatorios automáticos y notificaciones.',
            'triggers' => [
                'follow_up' => ['mucho' => 5, 'bastante' => 4, 'aveces' => 2, 'poco' => 1, 'no' => 0],
                'communication' => ['seguimiento' => 3, 'buscar' => 2],
            ],
        ],
        'communication' => [
            'title' => 'Comunicación interna',
            'reason' => 'Ordenar los canales de comunicación (WhatsApp, email, llamadas) reduce interrupciones y pérdidas de información.',
            'solution' => 'Panel centralizado o integración entre canales existentes.',
            'triggers' => [
                'communication' => ['whatsapp' => 3, 'emails' => 2, 'empleados' => 3],
                'tools' => ['whatsapp' => 2, 'varias' => 2],
            ],
        ],
        'data_entry' => [
            'title' => 'Introducción manual de datos',
            'reason' => 'Introducir los mismos datos en varios sitios es una de las tareas más automatizables mediante integraciones o formularios únicos.',
            'solution' => 'Integraciones o formulario único que alimente los sistemas actuales.',
            'triggers' => [
                'communication' => ['duplicidad' => 5, 'entre_programas' => 4],
                'tools' => ['excel' => 2, 'varias' => 3, 'papel' => 3],
            ],
        ],
        'work_orders' => [
            'title' => 'Partes de trabajo',
            'reason' => 'Registrar los partes desde el móvil y volcarlos automáticamente ahorra horas de administración cada semana.',
            'solution' => 'App web móvil para registrar trabajos + generación automática de informes.',
            'triggers' => [
                'documents' => ['partes' => 7, 'albaranes' => 3],
                'communication' => ['empleados' => 3, 'whatsapp' => 2],
                'sector' => ['construccion' => 3, 'mantenimiento' => 3],
            ],
        ],
        'organization' => [
            'title' => 'Organización y planificación del trabajo',
            'reason' => 'Un panel único con tareas, calendarios y responsables reduce reuniones y confusión.',
            'solution' => 'Panel de planificación a medida o herramienta existente configurada para tu flujo.',
            'triggers' => [
                'communication' => ['organizacion' => 4, 'buscar' => 2],
                'tools' => ['varias' => 2],
            ],
        ],
        'invoicing' => [
            'title' => 'Facturación',
            'reason' => 'La facturación recurrente y a partir de presupuestos aprobados se puede automatizar casi por completo.',
            'solution' => 'Módulo de facturación conectado con presupuestos, cobros y contabilidad.',
            'triggers' => [
                'documents' => ['facturas' => 4],
                'quotations' => ['manual' => 2, 'word_excel' => 2],
            ],
        ],
        'reporting' => [
            'title' => 'Generación de informes',
            'reason' => 'Si dedicas horas a preparar informes, un cuadro de mando automatizado los tendrá listos en tiempo real.',
            'solution' => 'Cuadro de mando con métricas conectadas a tu base de datos.',
            'triggers' => [
                'documents' => ['informes' => 4],
                'communication' => ['buscar' => 2],
            ],
        ],
    ],

    /*
     |------------------------------------------------------------------
     | Tipos de solución recomendada
     |------------------------------------------------------------------
     |
     | Elegimos uno en función del score y las horas ahorradas.
     | Cada tipo define su etiqueta, descripción y rango orientativo
     | de inversión (min/max en €).
     |
     */
    'solutions' => [
        'ninguna' => [
            'label' => 'No necesitas desarrollar nada todavía',
            'description' => 'Tu operativa actual ya está bastante automatizada. Antes de invertir en desarrollo, priorizaríamos optimizar procesos concretos o formación del equipo.',
            'investment' => [0, 0],
        ],
        'mejora_procesos' => [
            'label' => 'Mejorar procesos actuales',
            'description' => 'Con pequeños cambios y buenas prácticas puedes ganar tiempo sin necesidad de un desarrollo grande. Perfecto para consolidar antes de invertir en software.',
            'investment' => [500, 1500],
        ],
        'herramientas' => [
            'label' => 'Automatización con herramientas existentes',
            'description' => 'Existen herramientas del mercado que se pueden configurar para cubrir buena parte de tus necesidades sin desarrollo a medida.',
            'investment' => [800, 2500],
        ],
        'integracion' => [
            'label' => 'Integración entre herramientas',
            'description' => 'Ya utilizas varias herramientas. Conectarlas entre sí eliminaría duplicidades y trabajo manual repetitivo.',
            'investment' => [1500, 4000],
        ],
        'app_pequenia' => [
            'label' => 'Pequeña aplicación web',
            'description' => 'Una aplicación web ligera y a medida puede resolver los procesos que más tiempo consumen sin necesidad de un desarrollo complejo.',
            'investment' => [2500, 6000],
        ],
        'gestion_personalizada' => [
            'label' => 'Software de gestión personalizado',
            'description' => 'Un software de gestión adaptado a tu forma real de trabajar centralizaría clientes, documentos, presupuestos y seguimiento.',
            'investment' => [4000, 10000],
        ],
        'app_completa' => [
            'label' => 'Aplicación web completa',
            'description' => 'Tu operativa tiene volumen y complejidad suficientes para justificar una aplicación web completa a medida con paneles, integraciones y automatizaciones.',
            'investment' => [6000, 18000],
        ],
    ],

    /*
     |------------------------------------------------------------------
     | Páginas SEO por sector
     |------------------------------------------------------------------
     |
     | Cada entrada define una página sectorial en /automatiza/sectores/{slug}.
     | El controlador y la vista son únicos: al añadir un sector aquí,
     | queda publicado automáticamente. La lista es la fuente de verdad
     | del sitemap también.
     |
     */
    'sector_pages' => [

        'construccion' => [
            'title' => 'Automatizar una empresa de construcción',
            'meta_title' => 'Automatizar una empresa de construcción | Greetik',
            'meta_description' => 'Descubre cómo automatizar partes de trabajo, presupuestos, albaranes y seguimiento de obra. Análisis gratuito para pequeñas empresas de construcción.',
            'intro' => 'Las empresas de construcción pierden muchas horas cada semana en partes de trabajo, albaranes y presupuestos. Con la tecnología adecuada, la mayor parte de ese trabajo administrativo se puede automatizar.',
            'problems' => [
                'Partes de trabajo en papel o WhatsApp que hay que pasar después a Excel.',
                'Presupuestos preparados a mano que tardan días en salir.',
                'Albaranes y certificados de obra dispersos entre correos y carpetas.',
                'Falta de visibilidad de qué obra está en cada fase.',
            ],
            'processes' => [
                'Partes de trabajo desde móvil, con foto y firma.',
                'Presupuestos generados automáticamente desde plantillas.',
                'Albaranes y certificados generados a partir de los partes.',
                'Panel de estado de obras en tiempo real.',
            ],
            'example' => 'Una empresa con 6 operarios que dedica 15 horas semanales a papeleo puede recuperar entre 6 y 8 horas semanales con una app web de partes y una plantilla de presupuestos.',
        ],

        'gimnasios' => [
            'title' => 'Automatizar un gimnasio o centro deportivo',
            'meta_title' => 'Automatizar un gimnasio o centro deportivo | Greetik',
            'meta_description' => 'Reservas, cobros, seguimiento de socios y comunicación. Descubre qué puedes automatizar en tu gimnasio con este análisis gratuito.',
            'intro' => 'Los gimnasios y centros deportivos manejan reservas, altas, bajas, cobros y comunicación con socios. Todo eso se puede orquestar desde un único sistema.',
            'problems' => [
                'Reservas por WhatsApp o teléfono.',
                'Control manual de altas, bajas y cobros mensuales.',
                'Comunicación con socios dispersa en varios canales.',
                'Poca visibilidad de la ocupación real.',
            ],
            'processes' => [
                'Reservas online con confirmación automática.',
                'Recordatorios y cobros recurrentes automatizados.',
                'Panel de ocupación en tiempo real.',
                'Fichas de socio con historial de asistencia.',
            ],
            'example' => 'Un gimnasio con 200 socios puede reducir más del 50 % del tiempo dedicado a cobros y comunicación con un sistema unificado.',
        ],

        'entrenadores-personales' => [
            'title' => 'Automatizar el trabajo de un entrenador personal',
            'meta_title' => 'Automatizar el trabajo de un entrenador personal | Greetik',
            'meta_description' => 'Planificaciones, seguimiento de clientes, cobros y reservas: descubre qué puedes automatizar como entrenador personal. Análisis gratuito.',
            'intro' => 'Como entrenador personal pasas más tiempo del que crees preparando planificaciones y gestionando pagos. La tecnología adecuada te devuelve horas cada semana para dedicarlas a tus clientes.',
            'problems' => [
                'Planificaciones preparadas manualmente para cada cliente.',
                'Cobros por Bizum, transferencia o efectivo sin control.',
                'Seguimiento del progreso en cuadernos o notas.',
                'Reservas de sesiones por WhatsApp.',
            ],
            'processes' => [
                'Plataforma de planificaciones y seguimiento.',
                'Cobros y renovaciones automatizados.',
                'Reservas online con recordatorios.',
                'Comunicación centralizada con clientes.',
            ],
            'example' => 'Un entrenador con 20 clientes activos puede ahorrar entre 4 y 6 horas semanales con una plataforma tipo MyTrainik.',
        ],

        'mantenimiento' => [
            'title' => 'Automatizar una empresa de mantenimiento e instalaciones',
            'meta_title' => 'Automatizar una empresa de mantenimiento | Greetik',
            'meta_description' => 'Órdenes de trabajo, partes desde móvil, generación de informes: automatiza tu empresa de mantenimiento e instalaciones. Análisis gratuito.',
            'intro' => 'Las empresas de mantenimiento tienen técnicos en la calle y una oficina que debe centralizar toda la información. Es uno de los sectores con mayor potencial de automatización.',
            'problems' => [
                'Órdenes de trabajo por WhatsApp o teléfono.',
                'Partes que llegan tarde y sin foto ni firma.',
                'Falta de historial por cliente e instalación.',
                'Facturación manual a partir de trabajos hechos.',
            ],
            'processes' => [
                'Panel de órdenes de trabajo con reparto por técnico.',
                'Partes desde móvil con foto, firma y ubicación.',
                'Historial por cliente e instalación.',
                'Facturación automática a partir de los partes.',
            ],
            'example' => 'Una empresa con 5 técnicos puede recuperar más de 15 horas semanales solo automatizando partes y órdenes de trabajo.',
        ],

        'inmobiliarias' => [
            'title' => 'Automatizar una inmobiliaria',
            'meta_title' => 'Automatizar una inmobiliaria | Greetik',
            'meta_description' => 'Captación de contactos, seguimiento de clientes, gestión de inmuebles y contratos. Descubre qué puedes automatizar en tu inmobiliaria.',
            'intro' => 'Una inmobiliaria vive del seguimiento. Un CRM adaptado y flujos de captación automatizados pueden multiplicar tu productividad sin ampliar el equipo.',
            'problems' => [
                'Contactos que se pierden entre email, WhatsApp y llamadas.',
                'Fichas de inmuebles duplicadas en distintos portales.',
                'Contratos redactados manualmente.',
                'Falta de seguimiento comercial estructurado.',
            ],
            'processes' => [
                'CRM inmobiliario con seguimiento de oportunidades.',
                'Ficha de inmueble única y publicable en portales.',
                'Generación automática de contratos y hojas de encargo.',
                'Recordatorios de visitas y cierres.',
            ],
            'example' => 'Una inmobiliaria con 3 comerciales puede aumentar significativamente su tasa de conversión con un CRM sectorial y recordatorios automáticos.',
        ],

    ],
];
