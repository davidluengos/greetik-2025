@extends('front.layouts.app')

@php
    $seoTitle = 'Cuestionario de automatización | Greetik Automatiza';
    $seoDescription = 'Cuestionario gratuito para descubrir qué procesos puedes automatizar en tu empresa y cuánto podrías ahorrar.';
    $canonical = route('automatiza.wizard');
@endphp

@section('title', $seoTitle)

@push('styles')
    <link href="{{ asset('front/css/automatiza.css') }}?v=1" rel="stylesheet">
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="robots" content="noindex,follow">
@endpush

@section('content')
    <div class="aut-scope">
        <section class="aut-wizard">
            <div class="aut-container">
                <div style="text-align:center; margin-bottom: 24px;">
                    <h1 class="aut-h1" style="font-size:clamp(24px,3vw,32px);">Analiza tu empresa en 2-3 minutos</h1>
                    <p class="aut-lead" style="margin-bottom:0;">Responde con lo que mejor describa vuestra situación actual. Puedes volver atrás en cualquier momento.</p>
                </div>

                <form id="aut-form" class="aut-wizard-shell" method="POST" action="{{ route('automatiza.analyze') }}" novalidate>
                    @csrf
                    <input type="text" name="website" value="" class="aut-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
                    <input type="hidden" name="form_started_at" value="{{ time() }}">

                    <div class="aut-progress"><div class="aut-progress-bar" id="aut-progress-bar"></div></div>

                    <div class="aut-wizard-header">
                        <div class="aut-step-info">Paso <span class="aut-step-count" id="aut-current">1</span> de <span id="aut-total">11</span></div>
                        <div class="aut-step-info" id="aut-step-title-mini"></div>
                    </div>

                    <div id="aut-steps"></div>

                    <div class="aut-error" id="aut-error"></div>

                    <div class="aut-wizard-footer">
                        <button type="button" class="aut-btn aut-btn-secondary" id="aut-prev">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás
                        </button>
                        <button type="button" class="aut-btn aut-btn-primary" id="aut-next">
                            Continuar <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </button>
                        <button type="submit" class="aut-btn aut-btn-primary" id="aut-submit" style="display:none;">
                            Ver mi análisis <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>

                <p style="text-align:center; margin-top:18px; color:#6b7280; font-size:13px;">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    No pedimos ningún dato personal para ver tu análisis.
                </p>
            </div>
        </section>
    </div>

    <script>
    (function () {
        const CONFIG = @json($config, JSON_UNESCAPED_UNICODE);

        // Definición declarativa de los 11 pasos. Cambia aquí las preguntas
        // o el orden sin tocar el JS del wizard.
        const STEPS = [
            { name: 'sector', type: 'single', required: true,
              title: '¿A qué se dedica principalmente tu empresa?',
              hint: 'Selecciona el sector que mejor te describa.',
              options: CONFIG.sectors,
              extra: { type: 'text', name: 'sector_other', placeholder: 'Describe tu sector', showIf: 'otro',
                       label: 'Cuéntanos tu sector (opcional)' } },

            { name: 'company_size', type: 'single', required: true,
              title: '¿Cuántas personas trabajan en la empresa?',
              options: CONFIG.company_sizes },

            { name: 'tools', type: 'multi', required: true,
              title: '¿Cómo gestionáis actualmente el trabajo?',
              hint: 'Puedes seleccionar varias.',
              options: CONFIG.tools },

            { name: 'repetitive_hours', type: 'single', required: true,
              title: '¿Cuánto tiempo dedicáis cada semana a tareas repetitivas o administrativas?',
              options: CONFIG.repetitive_hours },

            { name: 'customer_management', type: 'single', required: true,
              title: '¿Cómo gestionáis actualmente clientes y contactos?',
              options: CONFIG.customer_management },

            { name: 'quotations', type: 'single', required: true,
              title: '¿Cómo preparáis presupuestos?',
              options: CONFIG.quotations },

            { name: 'follow_up', type: 'single', required: true,
              title: '¿Os cuesta hacer seguimiento de clientes, presupuestos o trabajos pendientes?',
              options: CONFIG.follow_up },

            { name: 'documents', type: 'multi', required: false,
              title: '¿Generáis documentos repetitivos?',
              hint: 'Marca los que apliquen.',
              options: CONFIG.documents },

            { name: 'communication', type: 'multi', required: false,
              title: '¿Dónde se pierde más tiempo actualmente?',
              hint: 'Puedes seleccionar varias.',
              options: CONFIG.communication },

            { name: 'main_problem', type: 'text', required: false,
              title: 'Si pudieras eliminar una tarea de tu día a día, ¿cuál sería?',
              hint: 'Opcional. Cuanto más concreto, mejor podemos entender vuestro caso.',
              placeholder: 'Ej.: cada viernes tengo que pasar los partes de los operarios de WhatsApp a Excel.' },

            { name: 'hourly_cost', type: 'single', required: true,
              title: '¿Cuál es aproximadamente el coste/hora de la persona que realiza estas tareas?',
              hint: 'Sirve para estimar el ahorro económico. Si no lo sabes, usamos un valor razonable.',
              options: CONFIG.hourly_costs },
        ];

        const state = { step: 0, values: {} };
        const form = document.getElementById('aut-form');
        const stepsContainer = document.getElementById('aut-steps');
        const progressBar = document.getElementById('aut-progress-bar');
        const currentLbl = document.getElementById('aut-current');
        const totalLbl = document.getElementById('aut-total');
        const miniTitle = document.getElementById('aut-step-title-mini');
        const errorBox = document.getElementById('aut-error');
        const prevBtn = document.getElementById('aut-prev');
        const nextBtn = document.getElementById('aut-next');
        const submitBtn = document.getElementById('aut-submit');

        totalLbl.textContent = STEPS.length;

        function renderSteps() {
            stepsContainer.innerHTML = '';
            STEPS.forEach((step, index) => {
                const wrap = document.createElement('div');
                wrap.className = 'aut-step' + (index === 0 ? ' is-active' : '');
                wrap.dataset.step = index;

                const h2 = document.createElement('h2');
                h2.textContent = step.title;
                wrap.appendChild(h2);

                if (step.hint) {
                    const hint = document.createElement('p');
                    hint.className = 'aut-step-hint';
                    hint.textContent = step.hint;
                    wrap.appendChild(hint);
                }

                if (step.type === 'text') {
                    const ta = document.createElement('textarea');
                    ta.className = 'aut-textarea';
                    ta.name = step.name;
                    ta.placeholder = step.placeholder || '';
                    ta.maxLength = 2000;
                    ta.addEventListener('input', () => { state.values[step.name] = ta.value; });
                    wrap.appendChild(ta);
                } else {
                    const opts = document.createElement('div');
                    opts.className = 'aut-options' + (Object.keys(step.options).length <= 4 ? ' is-single-col' : '');
                    Object.entries(step.options).forEach(([key, label]) => {
                        const opt = document.createElement('label');
                        opt.className = 'aut-option';
                        opt.dataset.type = step.type === 'multi' ? 'checkbox' : 'radio';
                        opt.dataset.value = key;
                        opt.innerHTML = '<span class="aut-mark"></span><span>' + escapeHtml(label) + '</span>';

                        const input = document.createElement('input');
                        input.type = step.type === 'multi' ? 'checkbox' : 'radio';
                        input.name = step.type === 'multi' ? step.name + '[]' : step.name;
                        input.value = key;
                        opt.appendChild(input);

                        opt.addEventListener('click', (e) => {
                            e.preventDefault();
                            toggleOption(step, opts, opt, key);
                        });
                        opts.appendChild(opt);
                    });
                    wrap.appendChild(opts);

                    // Campo extra (p. ej.: sector "otro").
                    if (step.extra) {
                        const extra = document.createElement('div');
                        extra.className = 'aut-field';
                        extra.dataset.extraFor = step.extra.showIf;
                        extra.style.display = 'none';
                        extra.style.marginTop = '16px';
                        extra.innerHTML = '<label>' + escapeHtml(step.extra.label) + '</label>' +
                                          '<input type="text" class="aut-input" name="' + step.extra.name + '" ' +
                                          'placeholder="' + escapeHtml(step.extra.placeholder) + '" maxlength="120">';
                        wrap.appendChild(extra);
                    }
                }
                stepsContainer.appendChild(wrap);
            });
        }

        function toggleOption(step, opts, opt, key) {
            if (step.type === 'single') {
                opts.querySelectorAll('.aut-option').forEach(o => o.classList.remove('is-selected'));
                opts.querySelectorAll('input').forEach(i => i.checked = false);
                opt.classList.add('is-selected');
                opt.querySelector('input').checked = true;
                state.values[step.name] = key;

                if (step.extra) {
                    const extra = opts.parentNode.querySelector('[data-extra-for]');
                    if (extra) extra.style.display = key === step.extra.showIf ? 'block' : 'none';
                }
            } else {
                const isSel = opt.classList.toggle('is-selected');
                opt.querySelector('input').checked = isSel;
                if (!Array.isArray(state.values[step.name])) state.values[step.name] = [];
                if (isSel) {
                    if (!state.values[step.name].includes(key)) state.values[step.name].push(key);
                } else {
                    state.values[step.name] = state.values[step.name].filter(v => v !== key);
                }
            }
            hideError();
        }

        function currentStepEl() { return stepsContainer.children[state.step]; }
        function currentDef() { return STEPS[state.step]; }

        function showError(msg) {
            errorBox.textContent = msg;
            errorBox.classList.add('is-visible');
        }
        function hideError() { errorBox.classList.remove('is-visible'); }

        function validateStep() {
            const def = currentDef();
            if (!def.required) return true;
            const val = state.values[def.name];
            if (def.type === 'single' && !val) return showError('Selecciona una opción para continuar.') || false;
            if (def.type === 'multi' && (!Array.isArray(val) || val.length === 0)) return showError('Selecciona al menos una opción.') || false;
            if (def.type === 'text' && !val) return showError('Este campo es obligatorio.') || false;
            return true;
        }

        function updateUi() {
            [...stepsContainer.children].forEach((el, i) => el.classList.toggle('is-active', i === state.step));
            const pct = ((state.step + 1) / STEPS.length) * 100;
            progressBar.style.width = pct + '%';
            currentLbl.textContent = state.step + 1;
            miniTitle.textContent = currentDef().title.length > 60 ? '' : currentDef().title;
            prevBtn.style.visibility = state.step === 0 ? 'hidden' : 'visible';
            const isLast = state.step === STEPS.length - 1;
            nextBtn.style.display = isLast ? 'none' : 'inline-flex';
            submitBtn.style.display = isLast ? 'inline-flex' : 'none';
            hideError();
            currentStepEl().scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        prevBtn.addEventListener('click', () => {
            if (state.step > 0) { state.step--; updateUi(); }
        });
        nextBtn.addEventListener('click', () => {
            if (!validateStep()) return;
            if (state.step < STEPS.length - 1) { state.step++; updateUi(); }
        });
        form.addEventListener('submit', (e) => {
            if (!validateStep()) { e.preventDefault(); return; }
            const sectorVal = state.values['sector'];
            const other = form.querySelector('input[name="sector_other"]');
            if (other && sectorVal !== 'otro') other.value = '';
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Calculando... <i class="fa fa-spinner fa-spin"></i>';
        });

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, (c) => ({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c]));
        }

        renderSteps();
        updateUi();
    })();
    </script>
@endsection
