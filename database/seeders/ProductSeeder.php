<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([

            // 1
            [
                'nombre' => 'Tarjeta Gráfica RTX',
                'descripcion' => 'Tarjeta gráfica (8GB GDDR7, 128 bits, DisplayPort 2.1, HDMI 2.1)',
                'precio' => 7000,
                'stock' => 30,
                'categoria' => 'Componentes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2
            [
                'nombre' => 'Procesador Intel Core i7',
                'descripcion' => 'Procesador 12ª Gen, 8 núcleos, 16 hilos',
                'precio' => 8500,
                'stock' => 20,
                'categoria' => 'Componentes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3
            [
                'nombre' => 'Memoria RAM 16GB DDR4',
                'descripcion' => 'Memoria RAM DDR4 3200MHz',
                'precio' => 1200,
                'stock' => 50,
                'categoria' => 'Componentes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 4
            [
                'nombre' => 'Disco SSD 1TB',
                'descripcion' => 'Unidad SSD NVMe 1TB',
                'precio' => 1800,
                'stock' => 40,
                'categoria' => 'Componentes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 5
            [
                'nombre' => 'Fuente de Poder 750W',
                'descripcion' => 'Fuente certificación 80 Plus Gold',
                'precio' => 1600,
                'stock' => 25,
                'categoria' => 'Componentes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 6
            [
                'nombre' => 'Mouse Gamer RGB',
                'descripcion' => 'Mouse óptico 16000 DPI',
                'precio' => 450,
                'stock' => 60,
                'categoria' => 'Periféricos',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 7
            [
                'nombre' => 'Teclado Mecánico',
                'descripcion' => 'Teclado mecánico switches rojos',
                'precio' => 950,
                'stock' => 35,
                'categoria' => 'Periféricos',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 8
            [
                'nombre' => 'Monitor 27 pulgadas',
                'descripcion' => 'Monitor Full HD 144Hz',
                'precio' => 4200,
                'stock' => 15,
                'categoria' => 'Periféricos',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 9
            [
                'nombre' => 'Audífonos Gamer',
                'descripcion' => 'Audífonos con micrófono y sonido 7.1',
                'precio' => 800,
                'stock' => 45,
                'categoria' => 'Periféricos',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 10
            [
                'nombre' => 'Webcam HD',
                'descripcion' => 'Cámara web 1080p',
                'precio' => 700,
                'stock' => 30,
                'categoria' => 'Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 11
            [
                'nombre' => 'Laptop Cooling Pad',
                'descripcion' => 'Base enfriadora con 4 ventiladores',
                'precio' => 600,
                'stock' => 40,
                'categoria' => 'Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 12
            [
                'nombre' => 'Cable HDMI 2.1',
                'descripcion' => 'Cable HDMI alta velocidad',
                'precio' => 250,
                'stock' => 100,
                'categoria' => 'Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 13
            [
                'nombre' => 'Router WiFi 6',
                'descripcion' => 'Router doble banda',
                'precio' => 2200,
                'stock' => 20,
                'categoria' => 'Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 14
            [
                'nombre' => 'Disco Duro Externo 2TB',
                'descripcion' => 'Disco USB 3.0',
                'precio' => 1900,
                'stock' => 25,
                'categoria' => 'Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 15
            [
                'nombre' => 'Licencia Windows 11',
                'descripcion' => 'Sistema operativo Windows 11 Pro',
                'precio' => 3200,
                'stock' => 10,
                'categoria' => 'Software',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 16
            [
                'nombre' => 'Antivirus Premium',
                'descripcion' => 'Licencia anual antivirus',
                'precio' => 900,
                'stock' => 50,
                'categoria' => 'Software',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 17
            [
                'nombre' => 'Office 365',
                'descripcion' => 'Licencia anual Office',
                'precio' => 1800,
                'stock' => 20,
                'categoria' => 'Software',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 18
            [
                'nombre' => 'Pasta Térmica',
                'descripcion' => 'Pasta térmica alta conductividad',
                'precio' => 150,
                'stock' => 80,
                'categoria' => 'Refacciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 19
            [
                'nombre' => 'Ventilador 120mm',
                'descripcion' => 'Ventilador RGB 120mm',
                'precio' => 300,
                'stock' => 60,
                'categoria' => 'Refacciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 20
            [
                'nombre' => 'Batería Laptop',
                'descripcion' => 'Batería de reemplazo',
                'precio' => 1400,
                'stock' => 15,
                'categoria' => 'Refacciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 21
            [
                'nombre' => 'Adaptador USB-C',
                'descripcion' => 'Adaptador USB-C a HDMI',
                'precio' => 400,
                'stock' => 35,
                'categoria' => 'Otros',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 22
            [
                'nombre' => 'Lector de Tarjetas',
                'descripcion' => 'Lector SD y microSD',
                'precio' => 280,
                'stock' => 50,
                'categoria' => 'Otros',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 23
            [
                'nombre' => 'Soporte para Monitor',
                'descripcion' => 'Soporte ajustable para monitor',
                'precio' => 900,
                'stock' => 20,
                'categoria' => 'Otros',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 24
            [
                'nombre' => 'Hub USB 4 Puertos',
                'descripcion' => 'Hub USB 3.0',
                'precio' => 350,
                'stock' => 45,
                'categoria' => 'Otros',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 25
            [
                'nombre' => 'Mousepad XL',
                'descripcion' => 'Mousepad gamer tamaño XL',
                'precio' => 300,
                'stock' => 70,
                'categoria' => 'Otros',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
