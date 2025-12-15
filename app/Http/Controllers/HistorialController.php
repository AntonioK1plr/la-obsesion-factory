<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function compras(Request $request)
    {
        $query = Compra::with('detalles.producto')->orderBy('fecha', 'desc');
        
        if ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }
        
        if ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }
        
        if ($request->filled('proveedor')) {
            $query->where('proveedor', 'like', '%' . $request->proveedor . '%');
        }
        
        // CAMBIO IMPORTANTE: usar paginate() en lugar de get()
        $compras = $query->paginate(10); // 10 items por página
        
        return view('historial.compras', compact('compras'));
    }

    public function ventas(Request $request)
    {
        $query = Venta::with(['cliente', 'detalles.producto', 'servicios'])
                     ->orderBy('fecha_venta', 'desc');
        
        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_venta', '>=', $request->fecha_inicio);
        }
        
        if ($request->filled('fecha_fin')) {
            $query->where('fecha_venta', '<=', $request->fecha_fin);
        }
        
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        
        // CAMBIO IMPORTANTE: usar paginate() en lugar de get()
        $ventas = $query->paginate(10); // 10 items por página
        
        $clientes = Cliente::all();
        
        return view('historial.ventas', compact('ventas', 'clientes'));
    }
}