<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\DetalleCompra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('detalles')->orderBy('fecha', 'desc')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('compras.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor' => 'required|string|max:100',
            'fecha' => 'required|date',
            'notas' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Calcular totales
        $subtotal = 0;
        foreach ($validated['productos'] as $item) {
            $subtotal += $item['cantidad'] * $item['precio_unitario'];
        }
        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        // Crear compra
        $compra = Compra::create([
            'proveedor' => $validated['proveedor'],
            'fecha' => $validated['fecha'],
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'notas' => $validated['notas'] ?? null,
        ]);

        // Crear detalles
        foreach ($validated['productos'] as $item) {
            DetalleCompra::create([
                'compra_id' => $compra->id,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'subtotal' => $item['cantidad'] * $item['precio_unitario'],
            ]);

            // Actualizar stock del producto
            $producto = Producto::find($item['producto_id']);
            $producto->stock += $item['cantidad'];
            $producto->save();
        }

        return redirect()->route('compras.index')
            ->with('success', 'Compra registrada exitosamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load('detalles.producto');
        return view('compras.show', compact('compra'));
    }
}