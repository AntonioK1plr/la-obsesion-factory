@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-pencil"></i> Editar Producto: {{ $producto->nombre }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('productos.update', $producto) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select class="form-select @error('categoria') is-invalid @enderror" 
                            id="categoria" name="categoria" required>
                        <option value="Componentes" {{ old('categoria', $producto->categoria) == 'Componentes' ? 'selected' : '' }}>Componentes</option>
                        <option value="Accesorios" {{ old('categoria', $producto->categoria) == 'Accesorios' ? 'selected' : '' }}>Accesorios</option>
                        <option value="Periféricos" {{ old('categoria', $producto->categoria) == 'Periféricos' ? 'selected' : '' }}>Periféricos</option>
                        <option value="Software" {{ old('categoria', $producto->categoria) == 'Software' ? 'selected' : '' }}>Software</option>
                        <option value="Refacciones" {{ old('categoria', $producto->categoria) == 'Refacciones' ? 'selected' : '' }}>Refacciones</option>
                        <option value="Otros" {{ old('categoria', $producto->categoria) == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                    @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="precio" class="form-label">Precio de Venta *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" 
                               id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required min="0">
                    </div>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="stock" class="form-label">Stock Actual *</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                           id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" required min="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection