@extends('front.layouts.app')

@php
    /** @var \App\Models\AutomationAssessment $assessment */
    /** @var \App\Services\Automatiza\AutomationResult $result */
    $seoTitle = 'Tu análisis de automatización | Greetik Automatiza';
    $seoDescription = 'Resultado de tu análisis: nivel de automatización, ahorro potencial y procesos prioritarios.';
    $canonical = route('automatiza.result', ['assessment' => $assessment->uuid]);
    $formatEuro = fn (int $v) => number_format($v, 0, ',', '.').' €';
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
        <section class="aut-result-hero">
            <div class="aut-container">
                <span class="aut-eyebrow">Análisis completado · {{ $result->scoreLevelLabel }}</span>
                <h1 class="aut-result-title">Tu empresa tiene potencial de automatización</h1>
                <p class="aut-result-sub">
                    Basado en tus respuestas, este es el resumen de tu análisis. Toda la información es orientativa y está pensada
                    para ayudarte a decidir por dónde empezar.
                </p>

                @if (session('status'))
                    <div class="aut-alert">{{ session('status') }}</div>
                @endif

                <div class="aut-metric-grid">
                    <div class="aut-metric" style="display:flex; align-items:center; gap:20px;">
                        <div class="aut-score-ring" style="--pct: {{ $result->score }};">
                            <span>{{ $result->score }}</span><small>/100</small>
                        </div>
                        <div>
                            <div class="aut-metric-label">Potencial de automatización</div>
                            <div class="aut-metric-value">{{ $result->scoreLevelLabel }}</div>
                            <div class="aut-metric-hint">Cuanto más alto, más margen de mejora.</div>
                        </div>
                    </div>
                    <div class="aut-metric">
                        <div class="aut-metric-label">Tiempo que podrías ahorrar</div>
                        <div class="aut-metric-value">
                            {{ rtrim(rtrim(number_format($result->hoursSavedPerWeek, 1, ',', '.'), '0'), ',') }}
                            <span style="font-size:16px; color:#6b7280;">h / semana</span>
                        </div>
                        <div class="aut-metric-hint">Estimación conservadora con tus datos.</div>
                    </div>
                    <div class="aut-metric">
                        <div class="aut-metric-label">Ahorro anual estimado</div>
                        <div class="aut-metric-value">{{ $formatEuro($result->annualSaving) }}</div>
                        <div class="aut-metric-hint">
                            Aprox. {{ $formatEuro($result->monthlySaving) }}/mes.
                            @if ($result->hourlyCostIsEstimate)
                                <br><em>Coste/hora estimado.</em>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="aut-section">
            <div class="aut-container">
                <h2 class="aut-section-title" style="text-align:center;">Los 3 procesos por los que empezaría</h2>
                <p class="aut-section-lead">
                    Estos son los procesos con mayor potencial de automatización en tu caso, ordenados por impacto.
                </p>
                @if (count($result->recommendations) === 0)
                    <div class="aut-card">
                        <p>Con tus respuestas actuales no hemos detectado procesos con potencial claro. Eso suele ser buena señal.</p>
                    </div>
                @else
                    <div class="aut-grid aut-grid-3">
                        @foreach ($result->recommendations as $index => $rec)
                            <div class="aut-card aut-process-card">
                                <span class="aut-tag">{{ $index + 1 }}. {{ $rec->potentialLabel }}</span>
                                <h3>{{ $rec->title }}</h3>
                                <p>{{ $rec->reason }}</p>
                                <p class="aut-solution"><strong>Solución típica:</strong> {{ $rec->solution }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="aut-section aut-section-alt">
            <div class="aut-container">
                <div class="aut-grid aut-grid-2">
                    <div>
                        <h2 class="aut-section-title">Qué tipo de solución necesitas</h2>
                        <p style="color:#6b7280;">Según el análisis, la aproximación que más encaja con tu situación es:</p>
                        <div class="aut-card" style="margin-top:14px;">
                            <h3>{{ $result->recommendedSolutionLabel }}</h3>
                            <p style="margin-bottom:14px;">{{ $result->recommendedSolutionDescription }}</p>
                            @if ($result->investmentMax > 0)
                                <p style="margin:0; font-weight:600; color:#0f172a;">
                                    Inversión orientativa:
                                    {{ $formatEuro($result->investmentMin) }} – {{ $formatEuro($result->investmentMax) }}
                                </p>
                                <p style="font-size:13px; color:#6b7280; margin-top:8px;">
                                    Esta estimación es orientativa y sirve para ayudarte a valorar si merece la pena estudiar
                                    el proyecto. El coste real depende de las funcionalidades, integraciones y complejidad.
                                    No es un presupuesto de Greetik.
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="aut-callout" id="contacto">
                        <h3>Qué haría Greetik</h3>
                        <p>
                            En Greetik desarrollamos aplicaciones web y herramientas a medida para pequeñas empresas que
                            necesitan adaptar la tecnología a su forma real de trabajar. Si quieres, estudiamos tu caso
                            concreto sin compromiso.
                        </p>

                        @if ($assessment->hasLead())
                            <p style="color:#a7f3d0;"><i class="fa fa-check"></i> Hemos recibido tus datos. Te contactamos pronto.</p>
                        @else
                            <form method="POST" action="{{ route('automatiza.contact', ['assessment' => $assessment->uuid]) }}" class="aut-lead-form" style="color:#0f172a;">
                                @csrf
                                <input type="text" name="website" value="" class="aut-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
                                <input type="hidden" name="form_started_at" value="{{ time() }}">

                                <h3>Quiero estudiar mi caso</h3>
                                <p class="aut-sub">Enviaremos tu informe y te contactaremos para hablarlo. Sin compromiso.</p>

                                @if ($errors->any())
                                    <div class="aut-alert" style="background:#fef2f2; border-color:#fecaca; color:#991b1b;">
                                        @foreach ($errors->all() as $err)
                                            <div>{{ $err }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="aut-lead-grid">
                                    <div class="aut-field">
                                        <label>Nombre *</label>
                                        <input type="text" name="name" class="aut-input" value="{{ old('name') }}" required maxlength="120">
                                    </div>
                                    <div class="aut-field">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="aut-input" value="{{ old('email') }}" required maxlength="255">
                                    </div>
                                    <div class="aut-field">
                                        <label>Empresa</label>
                                        <input type="text" name="company" class="aut-input" value="{{ old('company') }}" maxlength="150">
                                    </div>
                                    <div class="aut-field">
                                        <label>Teléfono</label>
                                        <input type="text" name="phone" class="aut-input" value="{{ old('phone') }}" maxlength="40">
                                    </div>
                                </div>
                                <div class="aut-field">
                                    <label class="aut-checkbox">
                                        <input type="checkbox" name="privacy" value="1" required>
                                        <span>He leído y acepto la <a href="{{ route('legal.page', ['slug' => 'politica-de-privacidad']) }}" target="_blank" rel="noopener">política de privacidad</a>.</span>
                                    </label>
                                </div>
                                <button type="submit" class="aut-btn aut-btn-primary" style="width:100%;">
                                    Quiero estudiar mi caso <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                                <p style="font-size:12px; color:#6b7280; margin: 10px 0 0;">
                                    Puedes seguir viendo tu análisis sin dejar tus datos.
                                </p>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="aut-section">
            <div class="aut-container">
                <h2 class="aut-section-title" style="text-align:center;">Resumen de tus respuestas</h2>
                <p class="aut-section-lead">Estos son los datos con los que hemos calculado tu análisis.</p>
                <div class="aut-card">
                    <dl class="aut-summary">
                        @if ($inputLabels['sector'])
                            <dt>Sector</dt><dd>{{ $inputLabels['sector'] }}{{ $assessment->sector_other ? ' (' . $assessment->sector_other . ')' : '' }}</dd>
                        @endif
                        @if ($inputLabels['company_size'])
                            <dt>Personas</dt><dd>{{ $inputLabels['company_size'] }}</dd>
                        @endif
                        @if (! empty($inputLabels['tools']))
                            <dt>Herramientas actuales</dt><dd>{{ implode(', ', $inputLabels['tools']) }}</dd>
                        @endif
                        @if ($inputLabels['repetitive_hours'])
                            <dt>Horas repetitivas/semana</dt><dd>{{ $inputLabels['repetitive_hours'] }}</dd>
                        @endif
                        @if ($inputLabels['customer_management'])
                            <dt>Gestión de clientes</dt><dd>{{ $inputLabels['customer_management'] }}</dd>
                        @endif
                        @if ($inputLabels['quotations'])
                            <dt>Presupuestos</dt><dd>{{ $inputLabels['quotations'] }}</dd>
                        @endif
                        @if ($inputLabels['follow_up'])
                            <dt>Dificultad de seguimiento</dt><dd>{{ $inputLabels['follow_up'] }}</dd>
                        @endif
                        @if (! empty($inputLabels['documents']))
                            <dt>Documentos repetitivos</dt><dd>{{ implode(', ', $inputLabels['documents']) }}</dd>
                        @endif
                        @if (! empty($inputLabels['communication']))
                            <dt>Se pierde tiempo en</dt><dd>{{ implode(', ', $inputLabels['communication']) }}</dd>
                        @endif
                        @if ($inputLabels['hourly_cost'])
                            <dt>Coste/hora</dt><dd>{{ $inputLabels['hourly_cost'] }}</dd>
                        @endif
                        @if ($assessment->main_problem)
                            <dt>Tarea que eliminarías</dt><dd>{{ $assessment->main_problem }}</dd>
                        @endif
                    </dl>
                </div>

                <div style="text-align:center; margin-top: 26px;">
                    <a href="{{ route('automatiza.wizard') }}" class="aut-btn aut-btn-secondary">
                        <i class="fa fa-refresh" aria-hidden="true"></i> Rehacer el análisis
                    </a>
                    <a href="{{ route('automatiza.landing') }}" class="aut-btn aut-btn-ghost">Volver al inicio</a>
                </div>
            </div>
        </section>
    </div>
@endsection
