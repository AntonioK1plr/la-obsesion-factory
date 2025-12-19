<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentasSeeder extends Seeder
{
    public function run(): void
    {
        $clientes  = DB::table('clientes')->pluck('id');
        $productos = DB::table('productos')->get();
        $servicios = DB::table('servicios')->get();

        $fechaInicio = Carbon::create(date('Y'), 9, 1);
        $fechaFin    = Carbon::create(date('Y'), 11, 30);

        // Crear 30 ventas
        for ($i = 0; $i < 30; $i++) {

            $fechaVenta = Carbon::createFromTimestamp(
                rand($fechaInicio->timestamp, $fechaFin->timestamp)
            );

            // Crear venta base
            $ventaId = DB::table('ventas')->insertGetId([
                'cliente_id' => $clientes->random(),
                'fecha_venta' => $fechaVenta->format('Y-m-d'),
                'subtotal' => 0,
                'iva' => 0,
                'total' => 0,
                'observaciones' => collect([
                    'Pago en efectivo',
                    'Pago con tarjeta',
                    'Transferencia bancaria',
                    'Pago mixto',
                    null
                ])->random(),
                'estado' => 'completada',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $subtotalVenta = 0;

            // ---- Productos (1 a 4 por venta) ----
            $productosVenta = rand(1, 4);

            for ($j = 0; $j < $productosVenta; $j++) {
                $producto = $productos->random();
                $cantidad = rand(1, 3);
                $subtotal = $cantidad * $producto->precio;

                DB::table('detalle_ventas')->insert([
                    'venta_id' => $ventaId,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $subtotalVenta += $subtotal;
            }

            // ---- Servicios (0 a 2 por venta) ----
            $serviciosVenta = rand(0, 2);

            for ($k = 0; $k < $serviciosVenta; $k++) {
                $servicio = $servicios->random();

                DB::table('venta_servicio')->insert([
                    'venta_id' => $ventaId,
                    'servicio_id' => $servicio->id,
                    'costo' => $servicio->costo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $subtotalVenta += $servicio->costo;
            }

            // Calcular IVA y total
            $iva = $subtotalVenta * 0.16;
            $total = $subtotalVenta + $iva;

            DB::table('ventas')
                ->where('id', $ventaId)
                ->update([
                    'subtotal' => $subtotalVenta,
                    'iva' => $iva,
                    'total' => $total,
                ]);
        }
    }
}
