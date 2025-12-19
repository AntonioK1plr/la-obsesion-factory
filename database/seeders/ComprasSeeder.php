<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComprasSeeder extends Seeder
{
    public function run(): void
    {
        $productos = DB::table('productos')->get();

        $proveedores = [
            'NVIDIA',
            'TechMexico',
            'Intel',
            'AMD',
            'ASUS',
            'Gigabyte',
            'MSI',
            'Kingston',
            'Seagate',
            'Western Digital'
        ];

        $fechaInicio = Carbon::create(date('Y'), 9, 1);
        $fechaFin    = Carbon::create(date('Y'), 11, 30);

        // Crear 25 compras
        for ($i = 0; $i < 25; $i++) {

            $fechaCompra = Carbon::createFromTimestamp(
                rand($fechaInicio->timestamp, $fechaFin->timestamp)
            );

            // Crear compra
            $compraId = DB::table('compras')->insertGetId([
                'proveedor' => collect($proveedores)->random(),
                'fecha' => $fechaCompra->format('Y-m-d'),
                'subtotal' => 0,
                'iva' => 0,
                'total' => 0,
                'notas' => collect([
                    'Compra al mayoreo',
                    'Reposición de inventario',
                    'Pedido urgente',
                    'Compra programada',
                    null
                ])->random(),
                'estado' => 'completada',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $subtotalCompra = 0;

            // Cada compra tendrá entre 1 y 5 productos
            $items = rand(1, 5);

            for ($j = 0; $j < $items; $j++) {

                $producto = $productos->random();
                $cantidad = rand(5, 20);

                // Precio de compra (60%–80% del precio de venta)
                $precioCompra = round($producto->precio * rand(60, 80) / 100, 2);
                $subtotal = $cantidad * $precioCompra;

                // Detalle de compra
                DB::table('detalle_compras')->insert([
                    'compra_id' => $compraId,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioCompra,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Incrementar stock del producto
                DB::table('productos')
                    ->where('id', $producto->id)
                    ->increment('stock', $cantidad);

                $subtotalCompra += $subtotal;
            }

            // Calcular IVA y total
            $iva = $subtotalCompra * 0.16;
            $total = $subtotalCompra + $iva;

            DB::table('compras')
                ->where('id', $compraId)
                ->update([
                    'subtotal' => $subtotalCompra,
                    'iva' => $iva,
                    'total' => $total,
                ]);
        }
    }
}
