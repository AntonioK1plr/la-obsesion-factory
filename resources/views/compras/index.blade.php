@extends('layouts.app')

@section('title', 'Compras')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-cart-plus"></i> Registro de Compras</h1>
    <a href="{{ route('compras.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nueva Compra
    </a>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-receipt"></i> Historial de Compras</h5>
    </div>
    <div class="card-body">
        @if($compras->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No hay compras registradas.
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
                            <td>{{ $compra->proveedor ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $compra->detalles_count ?? 0 }} productos</span>
                            </td>
                            <td class="fw-bold">${{ number_format($compra->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $compra->estado == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($compra->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Ver
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
                <strong>Total de compras:</strong> {{ $compras->count() }}
            </div>
            <div class="col-md-6 text-end">
                <strong>Monto total:</strong> ${{ number_format($compras->sum('total'), 2) }}
            </div>
        </div>
    </div>
</div>
@endsection