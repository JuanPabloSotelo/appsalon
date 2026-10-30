{{-- Campos del formulario de servicio (se usa en create y edit) --}}
<div class="mb-3">
    <label for="nombre" class="form-label">Nombre *</label>
    <input type="text" id="nombre" name="nombre" maxlength="60" required
           value="{{ old('nombre', $servicio->nombre) }}"
           class="form-control @error('nombre') is-invalid @enderror">
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="precio" class="form-label">Precio (COP) *</label>
        <div class="input-group has-validation">
            <span class="input-group-text">$</span>
            <input type="number" id="precio" name="precio" min="0" step="100" required
                   value="{{ old('precio', $servicio->precio !== null ? (int) $servicio->precio : '') }}"
                   class="form-control @error('precio') is-invalid @enderror">
            @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="duracion" class="form-label">Duración (minutos) *</label>
        <input type="number" id="duracion" name="duracion" min="10" max="480" step="5" required
               value="{{ old('duracion', $servicio->duracion) }}"
               class="form-control @error('duracion') is-invalid @enderror">
        @error('duracion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" maxlength="500"
              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $servicio->descripcion) }}</textarea>
    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check form-switch mb-4">
    {{-- El hidden envía 0 cuando el switch está apagado --}}
    <input type="hidden" name="activo" value="0">
    <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" value="1"
           @checked(old('activo', $servicio->activo))>
    <label class="form-check-label" for="activo">Servicio activo (visible en el catálogo)</label>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-salon"><i class="bi bi-check-lg"></i> {{ $textoBoton }}</button>
    <a href="{{ route('admin.servicios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>