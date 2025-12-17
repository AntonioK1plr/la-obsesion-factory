@extends('layouts.app')

@section('title', 'Detalle de Venta')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-receipt"></i> Detalle de Venta 
                <small class="fs-6">#VENT-{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</small>
            </h4>
            <div>
                <a href="{{ route('ventas.index') }}" class="btn btn-outline-dark btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button onclick="window.print()" class="btn btn-light btn-sm ms-2">
                    <i class="bi bi-printer"></i> Ticket
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Información de la Venta -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5><i class="bi bi-person"></i> Información del Cliente</h5>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Cliente:</th>
                        <td><strong>{{ $venta->cliente->nombre ?? 'Cliente no especificado' }}</strong></td>
                    </tr>
                    @if($venta->cliente)
                    <tr>
                        <th>Tipo:</th>
                        <td>
                            <span class="badge {{ $venta->cliente->tipo == 'frecuente' ? 'bg-success' : 'bg-info' }}">
                                {{ ucfirst($venta->cliente->tipo) }}
                            </span>
                        </td>
                    </tr>
                    @if($venta->cliente->telefono)
                    <tr>
                        <th>Teléfono:</th>
                        <td>{{ $venta->cliente->telefono }}</td>
                    </tr>
                    @endif
                    @endif
                    <tr>
                        <th>Fecha de Venta:</th>
                        <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            <span class="badge {{ $venta->estado == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h5><i class="bi bi-calculator"></i> Resumen Financiero</h5>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Subtotal:</th>
                        <td class="text-end">${{ number_format($venta->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>IVA (16%):</th>
                        <td class="text-end">${{ number_format($venta->iva, 2) }}</td>
                    </tr>
                    <tr>
                        <th><strong>Total:</strong></th>
                        <td class="text-end fw-bold fs-5">${{ number_format($venta->total, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Forma de Pago:</th>
                        <td class="text-end">Efectivo</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Productos Vendidos -->
        @if($venta->detalles && $venta->detalles->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Productos Vendidos</h5>
            </div>
            <div class="card-body">
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
                            @foreach($venta->detalles as $index => $detalle)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $detalle->producto->nombre ?? 'Producto no encontrado' }}</strong>
                                    @if($detalle->producto)
                                    <br>
                                    <small class="text-muted">
                                        Categoría: {{ $detalle->producto->categoria }}
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
                                <td class="text-end fw-bold">${{ number_format($venta->detalles->sum('subtotal'), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Servicios Vendidos -->
        @if($venta->servicios && $venta->servicios->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Servicios Vendidos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th class="text-end">Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venta->servicios as $index => $servicio)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $servicio->nombre }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($servicio->descripcion, 100) }}</small>
                                </td>
                                <td class="text-end fw-bold">${{ number_format($servicio->costo, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total Servicios:</strong></td>
                                <td class="text-end fw-bold">${{ number_format($venta->servicios->sum('costo'), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Observaciones -->
        @if($venta->observaciones)
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-chat-text"></i> Observaciones</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $venta->observaciones }}</p>
            </div>
        </div>
        @endif
    </div>
    
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted">
                    <i class="bi bi-clock-history"></i> 
                    Venta registrada: {{ $venta->created_at->format('d/m/Y H:i') }}
                </small>
            </div>
            <div>
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Historial
                </a>
                <a href="{{ route('historial.ventas') }}" class="btn btn-info ms-2">
                    <i class="bi bi-list"></i> Ver Todo el Historial
                </a>
                @if($venta->estado != 'cancelada')
                <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning ms-2">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Ticket de Venta para impresión -->
<div class="d-none d-print-block">
    <div class="text-center">
        <h3>La Obsesión Factory</h3>
        <p>Tienda de artículos y servicios de reparación electrónica</p>
        <hr>
        <h4>TICKET DE VENTA</h4>
        <p>#VENT-{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>
    
    <table width="100%">
        <tr>
            <td><strong>Fecha:</strong></td>
            <td>{{ $venta->fecha_venta->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Cliente:</strong></td>
            <td>{{ $venta->cliente->nombre ?? 'Cliente no especificado' }}</td>
        </tr>
    </table>
    
    <hr>
    
    @if($venta->detalles && $venta->detalles->count() > 0)
    <h5>PRODUCTOS:</h5>
    <table width="100%">
        @foreach($venta->detalles as $detalle)
        <tr>
            <td>{{ $detalle->producto->nombre ?? 'Producto' }}</td>
            <td class="text-end">{{ $detalle->cantidad }} x ${{ number_format($detalle->precio_unitario, 2) }}</td>
            <td class="text-end">${{ number_format($detalle->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    
    @if($venta->servicios && $venta->servicios->count() > 0)
    <h5>SERVICIOS:</h5>
    <table width="100%">
        @foreach($venta->servicios as $servicio)
        <tr>
            <td>{{ $servicio->nombre }}</td>
            <td class="text-end">${{ number_format($servicio->costo, 2) }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    
    <hr>
    
    <table width="100%">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td class="text-end">${{ number_format($venta->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td><strong>IVA (16%):</strong></td>
            <td class="text-end">${{ number_format($venta->iva, 2) }}</td>
        </tr>
        <tr>
            <td><strong>TOTAL:</strong></td>
            <td class="text-end"><strong>${{ number_format($venta->total, 2) }}</strong></td>
        </tr>
    </table>
    
    <hr>
    
    <div class="text-center">
        <p>¡Gracias por su compra!</p>
        <p>Vuelva pronto</p>
    </div>
</div>

<!-- Estilos para impresión -->
<style>
    @media print {
        .navbar, .card-footer, .btn, .d-print-none {
            display: none !important;
        }
        .d-print-block {
            display: block !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        body {
            font-size: 12px;
        }
        table {
            width: 100%;
            margin-bottom: 10px;
        }
        hr {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    }
</style>
@endsection