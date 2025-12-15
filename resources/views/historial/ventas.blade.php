@extends('layouts.app')

@section('title', 'Historial de Ventas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-receipt"></i> Historial de Ventas</h1>
    <a href="{{ route('ventas.create') }}" class="btn btn-warning">
        <i class="bi bi-plus-circle"></i> Nueva Venta
    </a>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('historial.ventas') }}" class="row g-3">
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
                <label for="cliente" class="form-label">Cliente</label>
                <select class="form-select" id="cliente" name="cliente_id">
                    <option value="">Todos los clientes</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Total Ventas</h5>
                <h2>{{ $ventas->total() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Ingresos Totales</h5>
                <h2>${{ number_format($ventas->sum('total'), 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning">
            <div class="card-body">
                <h5 class="card-title">Venta Promedio</h5>
                <h2>${{ number_format($ventas->avg('total') ?? 0, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Venta Más Alta</h5>
                <h2>${{ number_format($ventas->max('total') ?? 0, 2) }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de ventas -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-table"></i> Detalle de Ventas</h5>
    </div>
    <div class="card-body">
        @if($ventas->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No hay ventas en el historial. 
                <a href="{{ route('ventas.create') }}" class="alert-link">¡Registra la primera venta!</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Productos/Servicios</th>
                            <th>Subtotal</th>
                            <th>IVA</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                        <tr>
                            <td>VENT-{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                            <td><strong>{{ $venta->cliente->nombre ?? 'Cliente no especificado' }}</strong></td>
                            <td>
                                @php
                                    $totalItems = ($venta->detalles ? $venta->detalles->count() : 0) + 
                                                 ($venta->servicios ? $venta->servicios->count() : 0);
                                @endphp
                                @if($totalItems > 0)
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#modalDetalles{{ $venta->id }}">
                                    <i class="bi bi-eye"></i> Ver ({{ $totalItems }})
                                </button>
                                @else
                                <span class="badge bg-secondary">Sin items</span>
                                @endif
                            </td>
                            <td>${{ number_format($venta->subtotal, 2) }}</td>
                            <td>${{ number_format($venta->iva, 2) }}</td>
                            <td class="fw-bold">${{ number_format($venta->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $venta->estado == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    @if($venta->estado != 'cancelada')
                                    <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Modal para ver detalles -->
                        <div class="modal fade" id="modalDetalles{{ $venta->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detalles de la Venta #VENT-{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($venta->detalles && $venta->detalles->count() > 0)
                                        <h6>Productos:</h6>
                                        <ul class="list-group mb-3">
                                            @foreach($venta->detalles as $detalle)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>
                                                    <strong>{{ $detalle->producto->nombre ?? 'Producto' }}</strong><br>
                                                    <small>Código: {{ $detalle->producto->id ?? 'N/A' }}</small>
                                                </div>
                                                <div class="text-end">
                                                    {{ $detalle->cantidad }} x ${{ number_format($detalle->precio_unitario, 2) }}<br>
                                                    <strong>${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</strong>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                        
                                        @if($venta->servicios && $venta->servicios->count() > 0)
                                        <h6>Servicios:</h6>
                                        <ul class="list-group">
                                            @foreach($venta->servicios as $servicio)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>
                                                    <strong>{{ $servicio->nombre }}</strong><br>
                                                    <small>{{ Str::limit($servicio->descripcion, 50) }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <strong>${{ number_format($servicio->costo, 2) }}</strong>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            @if($ventas->hasPages())
            <div class="mt-3">
                {{ $ventas->withQueryString()->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection