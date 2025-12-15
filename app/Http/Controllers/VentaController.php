<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente', 'detalles', 'servicios')->orderBy('fecha_venta', 'desc')->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $servicios = Servicio::all();
        $clientes = Cliente::all();
        return view('ventas.create', compact('productos', 'servicios', 'clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'fecha_venta' => 'required|date',
            'observaciones' => 'nullable|string',
            'productos' => 'sometimes|array',
            'productos.*.producto_id' => 'required_with:productos|exists:productos,id',
            'productos.*.cantidad' => 'required_with:productos|integer|min:1',
            'productos.*.precio_unitario' => 'required_with:productos|numeric|min:0',
            'servicios' => 'sometimes|array',
            'servicios.*.servicio_id' => 'required_with:servicios|exists:servicios,id',
            'servicios.*.costo' => 'required_with:servicios|numeric|min:0',
        ]);

        // Calcular totales
        $subtotalProductos = 0;
        $subtotalServicios = 0;

        // Procesar productos
        if (isset($validated['productos'])) {
            foreach ($validated['productos'] as $item) {
                $subtotalProductos += $item['cantidad'] * $item['precio_unitario'];
            }
        }

        // Procesar servicios
        if (isset($validated['servicios'])) {
            foreach ($validated['servicios'] as $item) {
                $subtotalServicios += $item['costo'];
            }
        }

        $subtotal = $subtotalProductos + $subtotalServicios;
        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        // Crear venta
        $venta = Venta::create([
            'cliente_id' => $validated['cliente_id'] ?? null,
            'fecha_venta' => $validated['fecha_venta'],
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        // Crear detalles de productos
        if (isset($validated['productos'])) {
            foreach ($validated['productos'] as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                ]);

                // Actualizar stock del producto
                $producto = Producto::find($item['producto_id']);
                if ($producto->stock >= $item['cantidad']) {
                    $producto->stock -= $item['cantidad'];
                    $producto->save();
                }
            }
        }

        // Asociar servicios
        if (isset($validated['servicios'])) {
            foreach ($validated['servicios'] as $item) {
                $venta->servicios()->attach($item['servicio_id'], [
                    'costo' => $item['costo']
                ]);
            }
        }

        return redirect()->route('ventas.index')
            ->with('success', 'Venta registrada exitosamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto', 'servicios');
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $venta->load('detalles.producto', 'servicios');
        $productos = Producto::all();
        $servicios = Servicio::all();
        $clientes = Cliente::all();
        return view('ventas.edit', compact('venta', 'productos', 'servicios', 'clientes'));
    }

    public function update(Request $request, Venta $venta)
    {
        // Similar al store pero con actualización
        // Implementar según necesidades
    }
}