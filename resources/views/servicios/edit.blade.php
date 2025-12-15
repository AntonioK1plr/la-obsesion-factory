@extends('layouts.app')

@section('title', 'Editar Servicio')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-tools"></i> Editar Servicio: {{ $servicio->nombre }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('servicios.update', $servicio) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Servicio *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="Reparación" {{ old('categoria', $servicio->categoria) == 'Reparación' ? 'selected' : '' }}>Reparación</option>
                        <option value="Mantenimiento" {{ old('categoria', $servicio->categoria) == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="Instalación" {{ old('categoria', $servicio->categoria) == 'Instalación' ? 'selected' : '' }}>Instalación</option>
                        <option value="Diagnóstico" {{ old('categoria', $servicio->categoria) == 'Diagnóstico' ? 'selected' : '' }}>Diagnóstico</option>
                        <option value="Limpieza" {{ old('categoria', $servicio->categoria) == 'Limpieza' ? 'selected' : '' }}>Limpieza</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="costo" class="form-label">Costo del Servicio *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo', $servicio->costo) }}" required min="0">
                    </div>
                    @error('costo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tiempo_estimado" class="form-label">Tiempo Estimado (minutos) *</label>
                    <input type="number" class="form-control @error('tiempo_estimado') is-invalid @enderror" 
                           id="tiempo_estimado" name="tiempo_estimado" value="{{ old('tiempo_estimado', $servicio->tiempo_estimado) }}" required min="1">
                    @error('tiempo_estimado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción Detallada *</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $servicio->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Actualizar Servicio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection