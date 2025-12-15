@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="welcome-banner text-center">
    <h1 class="display-4 fw-bold">
        <i class="bi bi-cpu-fill"></i> Bienvenido a La Obsesión Factory
    </h1>
    <p class="lead fs-4">Tienda especializada en artículos y servicios de reparación electrónica</p>
    <p class="fs-5">Sistema de administración integral para tu negocio</p>
</div>

<div class="row mt-4">
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center border-primary">
            <div class="card-body">
                <i class="bi bi-tools display-4 text-primary mb-3"></i>
                <h5 class="card-title">Servicios</h5>
                <p class="card-text">Administra los servicios de reparación electrónica que ofreces a tus clientes.</p>
                <a href="{{ route('servicios.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-gear"></i> Gestionar Servicios
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center border-success">
            <div class="card-body">
                <i class="bi bi-cart-plus display-4 text-success mb-3"></i>
                <h5 class="card-title">Compras</h5>
                <p class="card-text">Registra las compras de productos y componentes para tu inventario.</p>
                <a href="{{ route('compras.index') }}" class="btn btn-outline-success">
                    <i class="bi bi-bag-plus"></i> Registrar Compra
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center border-warning">
            <div class="card-body">
                <i class="bi bi-cash-coin display-4 text-warning mb-3"></i>
                <h5 class="card-title">Ventas</h5>
                <p class="card-text">Gestiona las ventas de productos y servicios a tus clientes.</p>
                <a href="{{ route('ventas.index') }}" class="btn btn-outline-warning">
                    <i class="bi bi-currency-dollar"></i> Registrar Venta
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center border-info">
            <div class="card-body">
                <i class="bi bi-clock-history display-4 text-info mb-3"></i>
                <h5 class="card-title">Historial</h5>
                <p class="card-text">Consulta el historial completo de compras y ventas realizadas.</p>
                <div class="btn-group" role="group">
                    <a href="{{ route('historial.compras') }}" class="btn btn-outline-info">
                        <i class="bi bi-cart-check"></i> Compras
                    </a>
                    <a href="{{ route('historial.ventas') }}" class="btn btn-outline-info">
                        <i class="bi bi-receipt"></i> Ventas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-secondary">
            <div class="card-body">
                <h5 class="card-title text-center">
                    <i class="bi bi-people"></i> Gestión de Clientes
                </h5>
                <p class="card-text">Administra la información de tus clientes para un mejor servicio.</p>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-person-badge"></i> Ver Clientes
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-dark">
            <div class="card-body">
                <h5 class="card-title text-center">
                    <i class="bi bi-box-seam"></i> Control de Inventario
                </h5>
                <p class="card-text">Administra los productos en stock y sus características.</p>
                <a href="{{ route('productos.index') }}" class="btn btn-dark w-100">
                    <i class="bi bi-boxes"></i> Ver Productos
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas rápidas (puedes personalizar con datos reales) 
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Vista Rápida del Sistema</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3 class="text-primary" id="contador-productos">0</h3>
                        <p>Productos en Inventario</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-success" id="contador-clientes">0</h3>
                        <p>Clientes Registrados</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-warning" id="contador-servicios">0</h3>
                        <p>Servicios Disponibles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

@push('scripts')
<script>
    // Ejemplo de contadores animados (puedes reemplazar con datos reales)
    document.addEventListener('DOMContentLoaded', function() {
        // Simulación de conteo
        function animateCounter(elementId, finalValue, duration = 2000) {
            let element = document.getElementById(elementId);
            let start = 0;
            let increment = finalValue / (duration / 50);
            let timer = setInterval(() => {
                start += increment;
                if (start >= finalValue) {
                    element.textContent = finalValue;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start);
                }
            }, 50);
        }
        
        // Valores de ejemplo - en producción, obtendrías estos de la base de datos
        animateCounter('contador-productos', 42);
        animateCounter('contador-clientes', 28);
        animateCounter('contador-servicios', 15);
    });
</script>
@endpush
@endsection