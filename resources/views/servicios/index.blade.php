@extends('layouts.app')

@section('title', 'Servicios de Reparación')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-tools"></i> Servicios de Reparación</h1>
    <a href="{{ route('servicios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Servicio
    </a>
</div>

<div class="row">
    @foreach($servicios as $servicio)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">{{ $servicio->nombre }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $servicio->descripcion }}</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Costo:</strong> ${{ number_format($servicio->costo, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Tiempo estimado:</strong> {{ $servicio->tiempo_estimado }} minutos
                    </li>
                    <li class="list-group-item">
                        <strong>Estado:</strong> 
                        <span class="badge bg-success">Disponible</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('¿Eliminar este servicio?')">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($servicios->isEmpty())
<div class="alert alert-info">
    <i class="bi bi-info-circle"></i> No hay servicios registrados. ¡Agrega el primero!
</div>
@endif

<div class="mt-3">
    <p class="text-muted">Total de servicios: {{ $servicios->count() }}</p>
</div>
@endsection