@extends('layouts.app')

@section('title', 'Historial de Compras')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-cart-check"></i> Historial de Compras</h1>
    <a href="{{ route('compras.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nueva Compra
    </a>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('historial.compras') }}" class="row g-3">
            <div class="col-md-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                       value="{{ request('fecha_inicio') }}">
            </div>
            <div class="col-md-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                       value="{{ request('fecha_fin') }}">
            </div>
            <div class="col-md-3">
                <label for="proveedor" class="form-label">Proveedor</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" 
                       value="{{ request('proveedor') }}" placeholder="Nombre del proveedor">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Estadísticas - USAR total() para obtener todas las compras -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Total Compras</h5>
                <h2>{{ $compras->total() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Monto Total</h5>
                <h2>${{ number_format($compras->sum('total'), 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning">
            <div class="card-body">
                <h5 class="card-title">Promedio por Compra</h5>
                <h2>${{ number_format($compras->avg('total') ?? 0, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Última Compra</h5>
                <h6>{{ $compras->isNotEmpty() ? $compras->first()->fecha->format('d/m/Y') : 'N/A' }}</h6>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de compras -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-table"></i> Detalle de Compras</h5>
    </div>
    <div class="card-body">
        @if($compras->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No hay compras en el historial. 
                <a href="{{ route('compras.create') }}" class="alert-link">¡Registra la primera compra!</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Productos</th>
                            <th>Subtotal</th>
                            <th>IVA</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compras as $compra)
                        <tr>
                            <td>COMP-{{ str_pad($compra->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                            <td><strong>{{ $compra->proveedor }}</strong></td>
                            <td>
                                @if($compra->detalles && $compra->detalles->count() > 0)
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#modalProductos{{ $compra->id }}">
                                    <i class="bi bi-eye"></i> Ver ({{ $compra->detalles->count() }})
                                </button>
                                @else
                                <span class="badge bg-secondary">Sin productos</span>
                                @endif
                            </td>
                            <td>${{ number_format($compra->subtotal, 2) }}</td>
                            <td>${{ number_format($compra->iva, 2) }}</td>
                            <td class="fw-bold">${{ number_format($compra->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $compra->estado == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($compra->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                        
                        @if($compra->detalles && $compra->detalles->count() > 0)
                        <!-- Modal para ver productos -->
                        <div class="modal fade" id="modalProductos{{ $compra->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Productos de la Compra</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">
                                            @foreach($compra->detalles as $detalle)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>{{ $detalle->producto->nombre ?? 'Producto' }}</span>
                                                <span>{{ $detalle->cantidad }} x ${{ number_format($detalle->precio_unitario, 2) }}</span>
                                                <span class="fw-bold">${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación - AHORA SÍ FUNCIONARÁ -->
            @if($compras->hasPages())
            <div class="mt-3">
                {{ $compras->withQueryString()->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection