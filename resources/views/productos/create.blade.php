@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Registrar Nuevo Producto</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select class="form-select @error('categoria') is-invalid @enderror" 
                            id="categoria" name="categoria" required>
                        <option value="">Seleccionar categoría...</option>
                        <option value="Componentes">Componentes</option>
                        <option value="Accesorios">Accesorios</option>
                        <option value="Periféricos">Periféricos</option>
                        <option value="Software">Software</option>
                        <option value="Refacciones">Refacciones</option>
                        <option value="Otros">Otros</option>
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
                               id="precio" name="precio" value="{{ old('precio') }}" required min="0">
                    </div>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="stock" class="form-label">Stock Inicial *</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                           id="stock" name="stock" value="{{ old('stock', 0) }}" required min="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                    <input type="number" class="form-control" id="stock_minimo" 
                           name="stock_minimo" value="{{ old('stock_minimo', 5) }}" min="0">
                </div>
                
                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection