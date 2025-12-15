@extends('layouts.app')

@section('title', 'Productos - Inventario')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-box-seam"></i> Gestión de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Producto
    </a>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-list"></i> Lista de Productos en Inventario</h5>
    </div>
    <div class="card-body">
        @if($productos->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No hay productos registrados. ¡Agrega el primero!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td><strong>{{ $producto->nombre }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ $producto->categoria }}</span>
                            </td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge {{ $producto->stock > 10 ? 'bg-success' : ($producto->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $producto->stock }} unidades
                                </span>
                            </td>
                            <td>{{ Str::limit($producto->descripcion, 50) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Eliminar este producto?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="card-footer text-muted">
        Total: {{ $productos->count() }} productos registrados
    </div>
</div>
@endsection