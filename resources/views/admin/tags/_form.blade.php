@csrf

<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        value="{{ old('name', $tag->name) }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="repetitions">Repeticiones</label>
    <input type="number" class="form-control @error('repetitions') is-invalid @enderror" id="repetitions"
        name="repetitions" value="{{ old('repetitions', $tag->repetitions ?? 0) }}" min="0">
    @error('repetitions')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Cancelar</a>
