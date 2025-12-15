@extends('layouts.app')

@section('title', 'Nuevo Servicio')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-tools"></i> Registrar Nuevo Servicio</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('servicios.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Servicio *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="">Seleccionar categoría...</option>
                        <option value="Reparación">Reparación</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Instalación">Instalación</option>
                        <option value="Diagnóstico">Diagnóstico</option>
                        <option value="Limpieza">Limpieza</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="costo" class="form-label">Costo del Servicio *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo') }}" required min="0">
                    </div>
                    @error('costo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tiempo_estimado" class="form-label">Tiempo Estimado (minutos) *</label>
                    <input type="number" class="form-control @error('tiempo_estimado') is-invalid @enderror" 
                           id="tiempo_estimado" name="tiempo_estimado" value="{{ old('tiempo_estimado') }}" required min="1">
                    @error('tiempo_estimado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción Detallada *</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="requisitos" class="form-label">Requisitos o Notas</label>
                    <textarea class="form-control" id="requisitos" name="requisitos" rows="2">{{ old('requisitos') }}</textarea>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Guardar Servicio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection