@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-pencil"></i> Editar Venta #VENT-{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('ventas.update', $venta) }}" method="POST" id="ventaForm">
            @csrf
            @method('PUT')
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="cliente_id" class="form-label">Cliente *</label>
                    <select class="form-select @error('cliente_id') is-invalid @enderror" 
                            id="cliente_id" name="cliente_id" required>
                        <option value="">Seleccionar cliente...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id', $venta->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }} ({{ $cliente->tipo }})
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="fecha_venta" class="form-label">Fecha de Venta *</label>
                    <input type="date" class="form-control @error('fecha_venta') is-invalid @enderror" 
                           id="fecha_venta" name="fecha_venta" value="{{ old('fecha_venta', $venta->fecha_venta->format('Y-m-d')) }}" required>
                    @error('fecha_venta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select @error('estado') is-invalid @enderror" 
                            id="estado" name="estado">
                        <option value="completada" {{ old('estado', $venta->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="pendiente" {{ old('estado', $venta->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="cancelada" {{ old('estado', $venta->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="2">{{ old('observaciones', $venta->observaciones) }}</textarea>
                </div>
            </div>
            
            <!-- Productos/Servicios de la venta -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-cart"></i> Productos y Servicios</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="productos-tab" data-bs-toggle="tab" 
                                    data-bs-target="#productos" type="button">
                                <i class="bi bi-box-seam"></i> Productos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="servicios-tab" data-bs-toggle="tab" 
                                    data-bs-target="#servicios" type="button">
                                <i class="bi bi-tools"></i> Servicios
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="productos">
                            <div id="productos-container">
                                <!-- Productos existentes se agregarán aquí dinámicamente -->
                                @php
                                    $productoIndex = 0;
                                @endphp
                                @if($venta->detalles && $venta->detalles->count() > 0)
                                    @foreach($venta->detalles as $detalle)
                                    <div class="row producto-item mb-3 border-bottom pb-3" id="producto-existente-{{ $loop->index }}">
                                        <div class="col-md-5">
                                            <label class="form-label">Producto *</label>
                                            <select class="form-select producto-select" name="productos[{{ $loop->index }}][producto_id]" required>
                                                <option value="">Seleccionar producto...</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->id }}" 
                                                            data-precio="{{ $producto->precio }}" 
                                                            data-stock="{{ $producto->stock }}"
                                                            {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                                        {{ $producto->nombre }} (Stock: {{ $producto->stock }}, Precio: ${{ $producto->precio }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Cantidad *</label>
                                            <input type="number" class="form-control cantidad" 
                                                   name="productos[{{ $loop->index }}][cantidad]" 
                                                   min="1" value="{{ old('productos.' . $loop->index . '.cantidad', $detalle->cantidad) }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Precio Unitario *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" class="form-control precio" 
                                                       name="productos[{{ $loop->index }}][precio_unitario]" 
                                                       min="0" value="{{ old('productos.' . $loop->index . '.precio_unitario', $detalle->precio_unitario) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-item" data-item-id="{{ $detalle->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @php
                                        $productoIndex = $loop->index + 1;
                                    @endphp
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-3" id="agregar-producto">
                                <i class="bi bi-plus-circle"></i> Agregar Producto
                            </button>
                        </div>
                        
                        <div class="tab-pane fade" id="servicios">
                            <div id="servicios-container">
                                <!-- Servicios existentes se agregarán aquí dinámicamente -->
                                @php
                                    $servicioIndex = 0;
                                @endphp
                                @if($venta->servicios && $venta->servicios->count() > 0)
                                    @foreach($venta->servicios as $servicio)
                                    <div class="row servicio-item mb-3 border-bottom pb-3" id="servicio-existente-{{ $loop->index }}">
                                        <div class="col-md-8">
                                            <label class="form-label">Servicio *</label>
                                            <select class="form-select servicio-select" name="servicios[{{ $loop->index }}][servicio_id]" required>
                                                <option value="">Seleccionar servicio...</option>
                                                @foreach($servicios as $serv)
                                                    <option value="{{ $serv->id }}" 
                                                            data-costo="{{ $serv->costo }}"
                                                            {{ $servicio->id == $serv->id ? 'selected' : '' }}>
                                                        {{ $serv->nombre }} ($${serv->costo})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Costo *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" class="form-control costo" 
                                                       name="servicios[{{ $loop->index }}][costo]" 
                                                       min="0" value="{{ old('servicios.' . $loop->index . '.costo', $servicio->pivot->costo) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-item" data-servicio-id="{{ $servicio->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @php
                                        $servicioIndex = $loop->index + 1;
                                    @endphp
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-info mt-3" id="agregar-servicio">
                                <i class="bi bi-plus-circle"></i> Agregar Servicio
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Resumen -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-calculator"></i> Resumen de la Venta</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Subtotal Productos</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="subtotal-productos" 
                                           value="{{ number_format($venta->detalles->sum('subtotal'), 2) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Subtotal Servicios</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="subtotal-servicios" 
                                           value="{{ number_format($venta->servicios->sum('pivot.costo'), 2) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">IVA (16%)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="iva" 
                                           value="{{ number_format($venta->iva, 2) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control fw-bold" id="total" 
                                           value="{{ number_format($venta->total, 2) }}" readonly>
                                    <input type="hidden" name="total" id="total-hidden" value="{{ $venta->total }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Campos para eliminar items -->
            <input type="hidden" name="eliminar_detalles" id="eliminar-detalles" value="">
            <input type="hidden" name="eliminar_servicios" id="eliminar-servicios" value="">
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Actualizar Venta
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pasar datos usando data attributes -->
<div id="productos-data" 
     data-productos='@json($productos ?? [])'
     data-productos-index="{{ $productoIndex }}"
     style="display: none;">
</div>

<div id="servicios-data" 
     data-servicios='@json($servicios ?? [])'
     data-servicios-index="{{ $servicioIndex }}"
     style="display: none;">
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener datos desde data attributes
        const productosData = document.getElementById('productos-data');
        const serviciosData = document.getElementById('servicios-data');
        
        let productosDisponibles = [];
        let serviciosDisponibles = [];
        let productoIndex = parseInt(productosData?.dataset.productosIndex || 0);
        let servicioIndex = parseInt(serviciosData?.dataset.serviciosIndex || 0);
        
        // Arrays para tracking de eliminaciones
        let detallesEliminados = [];
        let serviciosEliminados = [];
        
        if (productosData && productosData.dataset.productos) {
            try {
                productosDisponibles = JSON.parse(productosData.dataset.productos);
            } catch (e) {
                console.error('Error parsing productos data:', e);
            }
        }
        
        if (serviciosData && serviciosData.dataset.servicios) {
            try {
                serviciosDisponibles = JSON.parse(serviciosData.dataset.servicios);
            } catch (e) {
                console.error('Error parsing servicios data:', e);
            }
        }
        
        // Referencias a elementos
        const agregarProductoBtn = document.getElementById('agregar-producto');
        const agregarServicioBtn = document.getElementById('agregar-servicio');
        const productosContainer = document.getElementById('productos-container');
        const serviciosContainer = document.getElementById('servicios-container');
        const eliminarDetallesInput = document.getElementById('eliminar-detalles');
        const eliminarServiciosInput = document.getElementById('eliminar-servicios');
        
        // Inicializar tabs de Bootstrap
        const triggerTabList = document.querySelectorAll('#myTab button');
        triggerTabList.forEach(function (triggerEl) {
            new bootstrap.Tab(triggerEl);
        });
        
        // Función para generar opciones de productos
        function generarOpcionesProductos() {
            if (!productosDisponibles.length) {
                return '<option value="">No hay productos disponibles</option>';
            }
            
            let options = '<option value="">Seleccionar producto...</option>';
            productosDisponibles.forEach(producto => {
                options += `<option value="${producto.id}" 
                    data-precio="${producto.precio}" 
                    data-stock="${producto.stock}">
                    ${producto.nombre} (Stock: ${producto.stock}, Precio: $${producto.precio})
                </option>`;
            });
            return options;
        }
        
        // Función para generar opciones de servicios
        function generarOpcionesServicios() {
            if (!serviciosDisponibles.length) {
                return '<option value="">No hay servicios disponibles</option>';
            }
            
            let options = '<option value="">Seleccionar servicio...</option>';
            serviciosDisponibles.forEach(servicio => {
                options += `<option value="${servicio.id}" 
                    data-costo="${servicio.costo}">
                    ${servicio.nombre} ($${servicio.costo})
                </option>`;
            });
            return options;
        }
        
        // Agregar producto NUEVO
        function agregarProducto() {
            const index = productoIndex++;
            const productoHTML = `
                <div class="row producto-item mb-3 border-bottom pb-3" data-index="${index}">
                    <div class="col-md-5">
                        <label class="form-label">Producto *</label>
                        <select class="form-select producto-select" name="productos[${index}][producto_id]" required>
                            ${generarOpcionesProductos()}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad *</label>
                        <input type="number" class="form-control cantidad" 
                               name="productos[${index}][cantidad]" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Precio Unitario *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control precio" 
                                   name="productos[${index}][precio_unitario]" min="0" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm eliminar-item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            
            productosContainer.insertAdjacentHTML('beforeend', productoHTML);
            configurarProducto(document.querySelector(`[data-index="${index}"]`), true);
        }
        
        // Agregar servicio NUEVO
        function agregarServicio() {
            const index = servicioIndex++;
            const servicioHTML = `
                <div class="row servicio-item mb-3 border-bottom pb-3" data-index="${index}">
                    <div class="col-md-8">
                        <label class="form-label">Servicio *</label>
                        <select class="form-select servicio-select" name="servicios[${index}][servicio_id]" required>
                            ${generarOpcionesServicios()}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Costo *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control costo" 
                                   name="servicios[${index}][costo]" min="0" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm eliminar-item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            
            serviciosContainer.insertAdjacentHTML('beforeend', servicioHTML);
            configurarServicio(document.querySelector(`[data-index="${index}"]`), true);
        }
        
        function configurarProducto(productoDiv, esNuevo = false) {
            if (!productoDiv) return;
            
            const select = productoDiv.querySelector('.producto-select');
            const cantidad = productoDiv.querySelector('.cantidad');
            const precio = productoDiv.querySelector('.precio');
            const eliminarBtn = productoDiv.querySelector('.eliminar-item');
            
            // Autocompletar precio
            if (select) {
                select.addEventListener('change', function() {
                    if (this.value && precio) {
                        const selectedOption = this.options[this.selectedIndex];
                        const precioProducto = selectedOption.getAttribute('data-precio');
                        const stock = selectedOption.getAttribute('data-stock');
                        
                        precio.value = precioProducto || 0;
                        
                        // Verificar stock
                        if (cantidad && cantidad.value > stock) {
                            cantidad.value = stock;
                            alert(`Solo hay ${stock} unidades disponibles`);
                        }
                        cantidad.max = stock;
                    }
                    calcularTotal();
                });
                
                // Si ya tiene valor seleccionado, disparar evento change
                if (select.value) {
                    select.dispatchEvent(new Event('change'));
                }
            }
            
            // Eventos para calcular total
            if (cantidad) cantidad.addEventListener('input', calcularTotal);
            if (precio) precio.addEventListener('input', calcularTotal);
            
            // Eliminar
            if (eliminarBtn) {
                if (!esNuevo) {
                    // Es un producto existente, guardar ID para eliminación
                    const detalleId = eliminarBtn.getAttribute('data-item-id');
                    if (detalleId) {
                        eliminarBtn.addEventListener('click', function() {
                            detallesEliminados.push(detalleId);
                            eliminarDetallesInput.value = detallesEliminados.join(',');
                            productoDiv.remove();
                            calcularTotal();
                        });
                    }
                } else {
                    // Es un producto nuevo
                    eliminarBtn.addEventListener('click', function() {
                        productoDiv.remove();
                        calcularTotal();
                    });
                }
            }
        }
        
        function configurarServicio(servicioDiv, esNuevo = false) {
            if (!servicioDiv) return;
            
            const select = servicioDiv.querySelector('.servicio-select');
            const costo = servicioDiv.querySelector('.costo');
            const eliminarBtn = servicioDiv.querySelector('.eliminar-item');
            
            // Autocompletar costo
            if (select) {
                select.addEventListener('change', function() {
                    if (this.value && costo) {
                        const selectedOption = this.options[this.selectedIndex];
                        const costoServicio = selectedOption.getAttribute('data-costo');
                        costo.value = costoServicio || 0;
                    }
                    calcularTotal();
                });
                
                // Si ya tiene valor seleccionado, disparar evento change
                if (select.value) {
                    select.dispatchEvent(new Event('change'));
                }
            }
            
            // Evento para calcular total
            if (costo) costo.addEventListener('input', calcularTotal);
            
            // Eliminar
            if (eliminarBtn) {
                if (!esNuevo) {
                    // Es un servicio existente, guardar ID para eliminación
                    const servicioId = eliminarBtn.getAttribute('data-servicio-id');
                    if (servicioId) {
                        eliminarBtn.addEventListener('click', function() {
                            serviciosEliminados.push(servicioId);
                            eliminarServiciosInput.value = serviciosEliminados.join(',');
                            servicioDiv.remove();
                            calcularTotal();
                        });
                    }
                } else {
                    // Es un servicio nuevo
                    eliminarBtn.addEventListener('click', function() {
                        servicioDiv.remove();
                        calcularTotal();
                    });
                }
            }
        }
        
        function calcularTotal() {
            let subtotalProductos = 0;
            let subtotalServicios = 0;
            
            // Calcular productos
            document.querySelectorAll('.producto-item').forEach(item => {
                const cantidad = parseFloat(item.querySelector('.cantidad')?.value) || 0;
                const precio = parseFloat(item.querySelector('.precio')?.value) || 0;
                subtotalProductos += cantidad * precio;
            });
            
            // Calcular servicios
            document.querySelectorAll('.servicio-item').forEach(item => {
                const costo = parseFloat(item.querySelector('.costo')?.value) || 0;
                subtotalServicios += costo;
            });
            
            const subtotal = subtotalProductos + subtotalServicios;
            const iva = subtotal * 0.16;
            const total = subtotal + iva;
            
            // Actualizar campos
            document.getElementById('subtotal-productos').value = subtotalProductos.toFixed(2);
            document.getElementById('subtotal-servicios').value = subtotalServicios.toFixed(2);
            document.getElementById('iva').value = iva.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            document.getElementById('total-hidden').value = total.toFixed(2);
        }
        
        // Configurar eventos para elementos existentes
        document.querySelectorAll('.producto-item').forEach(item => {
            if (!item.hasAttribute('data-index')) {
                configurarProducto(item, false);
            }
        });
        
        document.querySelectorAll('.servicio-item').forEach(item => {
            if (!item.hasAttribute('data-index')) {
                configurarServicio(item, false);
            }
        });
        
        // Configurar eventos para botones de agregar
        if (agregarProductoBtn) {
            agregarProductoBtn.addEventListener('click', agregarProducto);
        }
        
        if (agregarServicioBtn) {
            agregarServicioBtn.addEventListener('click', agregarServicio);
        }
        
        // Calcular total inicial
        calcularTotal();
    });
</script>
@endpush
@endsection