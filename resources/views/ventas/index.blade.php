@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-cash-coin"></i> Registro de Ventas</h1>
    <a href="{{ route('ventas.create') }}" class="btn btn-warning">
        <i class="bi bi-plus-circle"></i> Nueva Venta
    </a>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-receipt"></i> Historial de Ventas</h5>
    </div>
    <div class="card-body">
        @if($ventas->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No hay ventas registradas.
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
                            <td>{{ $venta->cliente->nombre ?? 'Cliente no especificado' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $venta->detalles_count ?? 0 }} items</span>
                            </td>
                            <td class="fw-bold">${{ number_format($venta->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $venta->estado == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <strong>Total de ventas:</strong> {{ $ventas->count() }}
            </div>
            <div class="col-md-6 text-end">
                <strong>Ingresos totales:</strong> ${{ number_format($ventas->sum('total'), 2) }}
            </div>
        </div>
    </div>
</div>
@endsection