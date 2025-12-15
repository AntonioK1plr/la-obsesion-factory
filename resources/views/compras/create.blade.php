@extends('layouts.app')

@section('title', 'Nueva Compra')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="bi bi-cart-plus"></i> Registrar Nueva Compra</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('compras.store') }}" method="POST" id="compraForm">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="proveedor" class="form-label">Proveedor *</label>
                    <input type="text" class="form-control @error('proveedor') is-invalid @enderror" 
                           id="proveedor" name="proveedor" value="{{ old('proveedor') }}" required>
                    @error('proveedor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha de Compra *</label>
                    <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                           id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label for="notas" class="form-label">Notas (opcional)</label>
                    <textarea class="form-control" id="notas" name="notas" rows="2">{{ old('notas') }}</textarea>
                </div>
            </div>
            
            <!-- Productos de la compra -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Productos de la Compra</h5>
                </div>
                <div class="card-body">
                    <div id="productos-container">
                        <!-- Los productos se agregarán dinámicamente aquí -->
                    </div>
                    
                    <button type="button" class="btn btn-outline-primary mt-3" id="agregar-producto">
                        <i class="bi bi-plus-circle"></i> Agregar Producto
                    </button>
                </div>
            </div>
            
            <!-- Resumen -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-calculator"></i> Resumen de la Compra</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Subtotal</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="subtotal" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">IVA (16%)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="iva" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                <a href="{{ route('compras.index') }}" class="btn btn-secondary me-md-2">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Registrar Compra
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pasar datos de productos usando data attribute -->
<div id="productos-data" 
     data-productos='@json($productos ?? [])'
     style="display: none;">
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener productos desde data attribute
        const productosData = document.getElementById('productos-data');
        let productosDisponibles = [];
        
        if (productosData && productosData.dataset.productos) {
            try {
                productosDisponibles = JSON.parse(productosData.dataset.productos);
            } catch (e) {
                console.error('Error parsing productos data:', e);
            }
        }
        
        let productoIndex = 0;
        const productosContainer = document.getElementById('productos-container');
        const agregarBtn = document.getElementById('agregar-producto');
        
        // Función para generar opciones de productos
        function generarOpcionesProductos() {
            if (!productosDisponibles.length) {
                return '<option value="">No hay productos disponibles</option>';
            }
            
            let options = '<option value="">Seleccionar producto...</option>';
            productosDisponibles.forEach(producto => {
                options += `<option value="${producto.id}" data-precio="${producto.precio}">
                    ${producto.nombre} (Stock: ${producto.stock})
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
                        <button type="button" class="btn btn-danger btn-sm eliminar-producto">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            
            productosContainer.insertAdjacentHTML('beforeend', productoHTML);
            
            // Configurar eventos para el nuevo producto
            const productoDiv = productosContainer.querySelector(`[data-index="${index}"]`);
            configurarProducto(productoDiv);
        }
        
        function configurarProducto(productoDiv) {
            if (!productoDiv) return;
            
            const select = productoDiv.querySelector('.producto-select');
            const cantidad = productoDiv.querySelector('.cantidad');
            const precio = productoDiv.querySelector('.precio');
            const eliminarBtn = productoDiv.querySelector('.eliminar-producto');
            
            // Autocompletar precio al seleccionar producto
            if (select) {
                select.addEventListener('change', function() {
                    if (this.value && precio) {
                        const selectedOption = this.options[this.selectedIndex];
                        const precioProducto = selectedOption.getAttribute('data-precio');
                        precio.value = precioProducto || 0;
                    }
                    calcularTotal();
                });
            }
            
            // Eventos para calcular total
            if (cantidad) cantidad.addEventListener('input', calcularTotal);
            if (precio) precio.addEventListener('input', calcularTotal);
            
            // Eliminar producto
            if (eliminarBtn) {
                eliminarBtn.addEventListener('click', function() {
                    productoDiv.remove();
                    calcularTotal();
                });
            }
        }
        
        function calcularTotal() {
            let subtotal = 0;
            
            document.querySelectorAll('.producto-item').forEach(item => {
                const cantidad = parseFloat(item.querySelector('.cantidad')?.value) || 0;
                const precio = parseFloat(item.querySelector('.precio')?.value) || 0;
                subtotal += cantidad * precio;
            });
            
            const iva = subtotal * 0.16;
            const total = subtotal + iva;
            
            // Actualizar campos
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('iva').value = iva.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            document.getElementById('total-hidden').value = total.toFixed(2);
        }
        
        // Evento para agregar producto
        if (agregarBtn) {
            agregarBtn.addEventListener('click', agregarProducto);
        }
        
        // Agregar primer producto
        agregarProducto();
    });
</script>
@endpush
@endsection