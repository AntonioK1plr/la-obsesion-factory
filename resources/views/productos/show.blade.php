@extends('layouts.app')

@section('title', 'Detalle de Producto')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-box-seam"></i> {{ $producto->nombre }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Información del Producto</h5>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Nombre:</th>
                        <td>{{ $producto->nombre }}</td>
                    </tr>
                    <tr>
                        <th>Categoría:</th>
                        <td>
                            <span class="badge bg-info">{{ $producto->categoria }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Precio:</th>
                        <td class="fw-bold">${{ number_format($producto->precio, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Stock:</th>
                        <td>
                            <span class="badge {{ $producto->stock > 10 ? 'bg-success' : ($producto->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $producto->stock }} unidades
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Registrado:</th>
                        <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Descripción</h5>
                <p>{{ $producto->descripcion ?? 'Sin descripción' }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning ms-2">
            <i class="bi bi-pencil"></i> Editar
        </a>
    </div>
</div>
@endsection