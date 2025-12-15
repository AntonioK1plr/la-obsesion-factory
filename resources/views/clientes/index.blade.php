@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-people"></i> Gestión de Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Nuevo Cliente
    </a>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-card-list"></i> Lista de Clientes</h5>
    </div>
    <div class="card-body">
        @if($clientes->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No hay clientes registrados.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Compras</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>
                                <strong>{{ $cliente->nombre }}</strong>
                                @if($cliente->tipo == 'frecuente')
                                    <span class="badge bg-success ms-1">Frecuente</span>
                                @endif
                            </td>
                            <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                            <td>{{ $cliente->email ?? 'N/A' }}</td>
                            <td>{{ Str::limit($cliente->direccion ?? 'N/A', 30) }}</td>
                            <td>
                                <span class="badge bg-info">{{ $cliente->ventas_count ?? 0 }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Eliminar este cliente?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection