@extends('admin.layouts.app')

@section('title', 'Leads Automatiza - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Leads Automatiza</h1>
        <div class="text-muted small">
            Total registros: <strong>{{ $stats['total'] }}</strong>
            &middot; Leads: <strong>{{ $stats['leads'] }}</strong>
            &middot; Sin revisar: <strong class="text-danger">{{ $stats['new'] }}</strong>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="form-row align-items-end">
                <div class="col-md-3 mb-2">
                    <label class="small text-muted mb-1">Filtro</label>
                    <select name="filter" class="form-control form-control-sm">
                        <option value="leads" @selected($filter === 'leads')>Solo leads (con contacto)</option>
                        <option value="new" @selected($filter === 'new')>Leads sin revisar</option>
                        <option value="all" @selected($filter === 'all')>Todos los registros</option>
                        <option value="anon" @selected($filter === 'anon')>Solo anonimos (sin contacto)</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="small text-muted mb-1">Sector</label>
                    <select name="sector" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach ($sectors as $key => $label)
                            <option value="{{ $key }}" @selected($currentSector === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="small text-muted mb-1">Nivel</label>
                    <select name="level" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach ($scoreLevels as $lvl)
                            <option value="{{ $lvl['key'] }}" @selected($currentLevel === $lvl['key'])>{{ $lvl['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="small text-muted mb-1">Buscar</label>
                    <input type="text" name="q" value="{{ $search }}" class="form-control form-control-sm" placeholder="Nombre, email, empresa, tel.">
                </div>
                <div class="col-md-1 mb-2">
                    <button class="btn btn-primary btn-sm btn-block">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Contacto</th>
                        <th>Sector</th>
                        <th class="text-center">Score</th>
                        <th class="text-right">Ahorro/anual</th>
                        <th>Solucion</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assessments as $a)
                        @php
                            $isLead = (bool) $a->contacted_at;
                            $isNew = $isLead && $a->reviewed_at === null;
                        @endphp
                        <tr class="{{ $isNew ? 'font-weight-bold' : '' }}">
                            <td class="text-nowrap">
                                @if ($isNew)
                                    <span class="badge badge-danger">Nuevo</span>
                                @elseif ($isLead)
                                    <span class="badge badge-success">Lead</span>
                                @else
                                    <span class="badge badge-secondary">Anon</span>
                                @endif
                                {{ $a->created_at?->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                @if ($isLead)
                                    <div>{{ $a->name ?: '-' }}</div>
                                    <div class="small text-muted">
                                        @if ($a->email)
                                            <a href="mailto:{{ $a->email }}">{{ $a->email }}</a>
                                        @endif
                                        @if ($a->company) &middot; {{ $a->company }} @endif
                                        @if ($a->phone) &middot; {{ $a->phone }} @endif
                                    </div>
                                @else
                                    <span class="text-muted">Sin datos de contacto</span>
                                @endif
                            </td>
                            <td>{{ $sectors[$a->sector] ?? ($a->sector ?: '-') }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $a->score }}</span>
                                <div class="small text-muted">{{ $a->score_level ?: '-' }}</div>
                            </td>
                            <td class="text-right text-nowrap">{{ number_format((int) $a->estimated_annual_saving, 0, ',', '.') }} EUR</td>
                            <td class="small">{{ $a->recommended_solution_key ?: '-' }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.automatiza-leads.show', $a) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-secondary btn-sm" href="{{ route('automatiza.result', ['assessment' => $a->uuid]) }}" target="_blank" rel="noopener" title="Ver resultado publico">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <form action="{{ route('admin.automatiza-leads.destroy', $a) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar registro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Sin registros para los filtros seleccionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $assessments->links() }}
        </div>
    </div>
@endsection
