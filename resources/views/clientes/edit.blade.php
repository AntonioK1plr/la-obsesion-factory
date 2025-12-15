@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-person-check"></i> Editar Cliente: {{ $cliente->nombre }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tipo" class="form-label">Tipo de Cliente</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="normal" {{ old('tipo', $cliente->tipo) == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="frecuente" {{ old('tipo', $cliente->tipo) == 'frecuente' ? 'selected' : '' }}>Frecuente</option>
                        <option value="empresa" {{ old('tipo', $cliente->tipo) == 'empresa' ? 'selected' : '' }}>Empresa</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                           id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $cliente->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <textarea class="form-control" id="direccion" name="direccion" rows="2">{{ old('direccion', $cliente->direccion) }}</textarea>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Actualizar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection