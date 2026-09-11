@extends('admin.layouts.app')

@section('title', 'Lead Automatiza - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @if ($assessment->contacted_at)
                Lead de {{ $assessment->name ?: 'sin nombre' }}
            @else
                Wizard anonimo #{{ $assessment->id }}
            @endif
        </h1>
        <div>
            <a href="{{ route('automatiza.result', ['assessment' => $assessment->uuid]) }}" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">
                <i class="fas fa-external-link-alt"></i> Ver resultado publico
            </a>
            <a href="{{ route('admin.automatiza-leads.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">Datos de contacto</div>
                <div class="card-body">
                    @if ($assessment->contacted_at)
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Nombre</dt>
                            <dd class="col-sm-8">{{ $assessment->name ?: '-' }}</dd>

                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">
                                @if ($assessment->email)
                                    <a href="mailto:{{ $assessment->email }}">{{ $assessment->email }}</a>
                                @else - @endif
                            </dd>

                            <dt class="col-sm-4">Empresa</dt>
                            <dd class="col-sm-8">{{ $assessment->company ?: '-' }}</dd>

                            <dt class="col-sm-4">Telefono</dt>
                            <dd class="col-sm-8">
                                @if ($assessment->phone)
                                    <a href="tel:{{ $assessment->phone }}">{{ $assessment->phone }}</a>
                                @else - @endif
                            </dd>

                            <dt class="col-sm-4">Contacto</dt>
                            <dd class="col-sm-8">{{ $assessment->contacted_at?->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-4">Revisado</dt>
                            <dd class="col-sm-8">{{ $assessment->reviewed_at?->format('d/m/Y H:i') ?: '-' }}</dd>

                            <dt class="col-sm-4">Privacidad</dt>
                            <dd class="col-sm-8">{{ $assessment->privacy_accepted ? 'Aceptada' : 'No' }}</dd>
                        </dl>
                    @else
                        <p class="text-muted mb-0">Este usuario completo el wizard pero no dejo datos de contacto.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">Resultado del analisis</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Score</dt>
                        <dd class="col-sm-7">
                            <span class="badge badge-info">{{ $assessment->score }}</span>
                            <span class="text-muted">/ 100 &middot; {{ $assessment->score_level ?: '-' }}</span>
                        </dd>

                        <dt class="col-sm-5">Horas ahorradas / semana</dt>
                        <dd class="col-sm-7">{{ $assessment->estimated_hours_saved }}</dd>

                        <dt class="col-sm-5">Ahorro anual estimado</dt>
                        <dd class="col-sm-7">{{ number_format((int) $assessment->estimated_annual_saving, 0, ',', '.') }} EUR</dd>

                        <dt class="col-sm-5">Solucion recomendada</dt>
                        <dd class="col-sm-7">{{ $assessment->recommended_solution_key ?: '-' }}</dd>

                        <dt class="col-sm-5">Inversion orientativa</dt>
                        <dd class="col-sm-7">
                            {{ number_format((int) $assessment->estimated_investment_min, 0, ',', '.') }} -
                            {{ number_format((int) $assessment->estimated_investment_max, 0, ',', '.') }} EUR
                        </dd>
                    </dl>

                    @if (! empty($assessment->recommendations))
                        <hr>
                        <div class="small text-muted mb-1">Recomendaciones:</div>
                        <ul class="mb-0 pl-3">
                            @foreach ((array) $assessment->recommendations as $rec)
                                <li>
                                    @if (is_array($rec))
                                        <strong>{{ $rec['title'] ?? '' }}</strong>
                                        @if (! empty($rec['description'])) &mdash; {{ $rec['description'] }} @endif
                                    @else
                                        {{ $rec }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">Respuestas del wizard</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Sector</dt>
                        <dd class="col-sm-7">
                            {{ $inputLabels['sector'] ?: '-' }}
                            @if ($assessment->sector_other) &middot; <em>{{ $assessment->sector_other }}</em> @endif
                        </dd>

                        <dt class="col-sm-5">Tamano empresa</dt>
                        <dd class="col-sm-7">{{ $inputLabels['company_size'] ?: '-' }}</dd>

                        <dt class="col-sm-5">Herramientas</dt>
                        <dd class="col-sm-7">
                            @if (! empty($inputLabels['tools']))
                                {{ implode(', ', $inputLabels['tools']) }}
                            @else - @endif
                        </dd>

                        <dt class="col-sm-5">Horas repetitivas / semana</dt>
                        <dd class="col-sm-7">{{ $inputLabels['repetitive_hours'] ?: '-' }}</dd>

                        <dt class="col-sm-5">Gestion clientes</dt>
                        <dd class="col-sm-7">{{ $inputLabels['customer_management'] ?: '-' }}</dd>

                        <dt class="col-sm-5">Presupuestos</dt>
                        <dd class="col-sm-7">{{ $inputLabels['quotations'] ?: '-' }}</dd>

                        <dt class="col-sm-5">Seguimiento</dt>
                        <dd class="col-sm-7">{{ $inputLabels['follow_up'] ?: '-' }}</dd>

                        <dt class="col-sm-5">Documentos</dt>
                        <dd class="col-sm-7">
                            @if (! empty($inputLabels['documents']))
                                {{ implode(', ', $inputLabels['documents']) }}
                            @else - @endif
                        </dd>

                        <dt class="col-sm-5">Comunicacion</dt>
                        <dd class="col-sm-7">
                            @if (! empty($inputLabels['communication']))
                                {{ implode(', ', $inputLabels['communication']) }}
                            @else - @endif
                        </dd>

                        <dt class="col-sm-5">Coste hora</dt>
                        <dd class="col-sm-7">{{ $inputLabels['hourly_cost'] ?: '-' }}</dd>

                        <dt class="col-sm-5">Principal problema</dt>
                        <dd class="col-sm-7" style="white-space: pre-wrap;">{{ $assessment->main_problem ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">Contexto tecnico</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Creado</dt>
                        <dd class="col-sm-8">{{ $assessment->created_at?->format('d/m/Y H:i:s') }}</dd>

                        <dt class="col-sm-4">UUID</dt>
                        <dd class="col-sm-8"><code>{{ $assessment->uuid }}</code></dd>

                        <dt class="col-sm-4">IP</dt>
                        <dd class="col-sm-8">{{ $assessment->ip ?: '-' }}</dd>

                        <dt class="col-sm-4">Referrer</dt>
                        <dd class="col-sm-8">
                            @if ($assessment->referrer)
                                <a href="{{ $assessment->referrer }}" target="_blank" rel="noopener">{{ $assessment->referrer }}</a>
                            @else - @endif
                        </dd>

                        <dt class="col-sm-4">User agent</dt>
                        <dd class="col-sm-8"><small class="text-muted">{{ $assessment->user_agent ?: '-' }}</small></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.automatiza-leads.destroy', $assessment) }}" method="POST" class="d-inline-block">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" onclick="return confirm('Eliminar registro?')">Eliminar</button>
    </form>
    <a href="{{ route('admin.automatiza-leads.index') }}" class="btn btn-secondary">Volver</a>
@endsection
