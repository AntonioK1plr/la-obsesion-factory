@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-cash-coin"></i> Registrar Nueva Venta</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('ventas.store') }}" method="POST" id="ventaForm">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="cliente_id" class="form-label">Cliente *</label>
                    <select class="form-select @error('cliente_id') is-invalid @enderror" 
                            id="cliente_id" name="cliente_id" required>
                        <option value="">Seleccionar cliente...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
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
                           id="fecha_venta" name="fecha_venta" value="{{ old('fecha_venta', date('Y-m-d')) }}" required>
                    @error('fecha_venta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
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
                                <!-- Productos se agregarán aquí -->
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-3" id="agregar-producto">
                                <i class="bi bi-plus-circle"></i> Agregar Producto
                            </button>
                        </div>
                        
                        <div class="tab-pane fade" id="servicios">
                            <div id="servicios-container">
                                <!-- Servicios se agregarán aquí -->
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
                                    <input type="text" class="form-control" id="subtotal-productos" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Subtotal Servicios</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="subtotal-servicios" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">IVA (16%)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="iva" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control fw-bold" id="total" value="0.00" readonly>
                                    <input type="hidden" name="total" id="total-hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Registrar Venta
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pasar datos usando data attributes -->
<div id="productos-data" 
     data-productos='@json($productos ?? [])'
     style="display: none;">
</div>

<div id="servicios-data" 
     data-servicios='@json($servicios ?? [])'
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
        
        let productoIndex = 0;
        let servicioIndex = 0;
        
        // Referencias a elementos
        const agregarProductoBtn = document.getElementById('agregar-producto');
        const agregarServicioBtn = document.getElementById('agregar-servicio');
        const productosContainer = document.getElementById('productos-container');
        const serviciosContainer = document.getElementById('servicios-container');
        
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
        
        // Agregar producto
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
            configurarProducto(document.querySelector(`[data-index="${index}"]`));
        }
        
        // Agregar servicio
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
            configurarServicio(document.querySelector(`[data-index="${index}"]`));
        }
        
        function configurarProducto(productoDiv) {
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
            }
            
            // Eventos para calcular total
            if (cantidad) cantidad.addEventListener('input', calcularTotal);
            if (precio) precio.addEventListener('input', calcularTotal);
            
            // Eliminar
            if (eliminarBtn) {
                eliminarBtn.addEventListener('click', function() {
                    productoDiv.remove();
                    calcularTotal();
                });
            }
        }
        
        function configurarServicio(servicioDiv) {
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
            }
            
            // Evento para calcular total
            if (costo) costo.addEventListener('input', calcularTotal);
            
            // Eliminar
            if (eliminarBtn) {
                eliminarBtn.addEventListener('click', function() {
                    servicioDiv.remove();
                    calcularTotal();
                });
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
        
        // Configurar eventos
        if (agregarProductoBtn) {
            agregarProductoBtn.addEventListener('click', agregarProducto);
        }
        
        if (agregarServicioBtn) {
            agregarServicioBtn.addEventListener('click', agregarServicio);
        }
        
        // Agregar primer producto
        agregarProducto();
    });
</script>
@endpush
@endsection