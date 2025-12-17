@extends('layouts.app')

@section('title', 'Detalle de Compra')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-cart-check"></i> Detalle de Compra 
                <small class="fs-6">#COMP-{{ str_pad($compra->id, 4, '0', STR_PAD_LEFT) }}</small>
            </h4>
            <div>
                <a href="{{ route('compras.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button onclick="window.print()" class="btn btn-light btn-sm ms-2">
                    <i class="bi bi-printer"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Información de la Compra -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5><i class="bi bi-info-circle"></i> Información General</h5>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Proveedor:</th>
                        <td><strong>{{ $compra->proveedor }}</strong></td>
                    </tr>
                    <tr>
                        <th>Fecha de Compra:</th>
                        <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            <span class="badge {{ $compra->estado == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($compra->estado) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Registrada el:</th>
                        <td>{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h5><i class="bi bi-calculator"></i> Resumen Financiero</h5>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Subtotal:</th>
                        <td class="text-end">${{ number_format($compra->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>IVA (16%):</th>
                        <td class="text-end">${{ number_format($compra->iva, 2) }}</td>
                    </tr>
                    <tr>
                        <th><strong>Total:</strong></th>
                        <td class="text-end fw-bold fs-5">${{ number_format($compra->total, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Productos Comprados -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Productos Comprados</h5>
            </div>
            <div class="card-body">
                @if($compra->detalles && $compra->detalles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unitario</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($compra->detalles as $index => $detalle)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $detalle->producto->nombre ?? 'Producto no encontrado' }}</strong>
                                        @if($detalle->producto)
                                        <br>
                                        <small class="text-muted">
                                            Categoría: {{ $detalle->producto->categoria }} | 
                                            Stock actual: {{ $detalle->producto->stock }}
                                        </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $detalle->cantidad }}</span>
                                    </td>
                                    <td class="text-end">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end fw-bold">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total Productos:</strong></td>
                                    <td class="text-end fw-bold">${{ number_format($compra->detalles->sum('subtotal'), 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> No hay productos registrados en esta compra.
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Notas -->
        @if($compra->notas)
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-chat-text"></i> Notas de la Compra</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $compra->notas }}</p>
            </div>
        </div>
        @endif
    </div>
    
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted">
                    <i class="bi bi-clock-history"></i> 
                    Última actualización: {{ $compra->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
            <div>
                <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Historial
                </a>
                <a href="{{ route('historial.compras') }}" class="btn btn-info ms-2">
                    <i class="bi bi-list"></i> Ver Todo el Historial
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estilos para impresión -->
<style>
    @media print {
        .navbar, .card-footer, .btn {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .card-header {
            background-color: #fff !important;
            color: #000 !important;
            border-bottom: 2px solid #000 !important;
        }
    }
</style>
@endsection