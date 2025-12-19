<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clientes')->insert([

            // 1–5
            [
                'nombre' => 'Juan Pérez López',
                'tipo' => 'normal',
                'telefono' => '5512345678',
                'email' => 'juan.perez@gmail.com',
                'direccion' => 'Av. Reforma 123, CDMX',
                'rfc' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María González Ruiz',
                'tipo' => 'normal',
                'telefono' => '5587654321',
                'email' => 'maria.gonzalez@gmail.com',
                'direccion' => 'Calle Juárez 45, CDMX',
                'rfc' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos Hernández Soto',
                'tipo' => 'frecuente',
                'telefono' => '5611122233',
                'email' => 'carlos.hs@hotmail.com',
                'direccion' => 'Col. Del Valle, CDMX',
                'rfc' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana Martínez Flores',
                'tipo' => 'normal',
                'telefono' => '5544455566',
                'email' => 'ana.mf@gmail.com',
                'direccion' => 'Col. Roma Norte, CDMX',
                'rfc' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis Ramírez Torres',
                'tipo' => 'frecuente',
                'telefono' => '5599988877',
                'email' => 'lramirez@yahoo.com',
                'direccion' => 'Col. Narvarte, CDMX',
                'rfc' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 6–8 (empresariales)
            [
                'nombre' => 'Soluciones Informáticas MX',
                'tipo' => 'empresarial',
                'telefono' => '5550001122',
                'email' => 'contacto@simx.com',
                'direccion' => 'Parque Industrial, CDMX',
                'rfc' => 'SIM010203AB4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tecnología Avanzada SA',
                'tipo' => 'empresarial',
                'telefono' => '5551239988',
                'email' => 'ventas@tecavanzada.com',
                'direccion' => 'Zona Industrial, Naucalpan',
                'rfc' => 'TAV040506CD7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Servicios Digitales Pro',
                'tipo' => 'empresarial',
                'telefono' => '5558887766',
                'email' => 'info@sdpro.com',
                'direccion' => 'Polanco, CDMX',
                'rfc' => 'SDP070809EF2',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 9–25 (clientes de prueba realistas)
            ...collect(range(9, 25))->map(function ($i) {
                return [
                    'nombre' => "Cliente Prueba $i",
                    'tipo' => 'normal',
                    'telefono' => '55000000' . $i,
                    'email' => "cliente$i@correo.com",
                    'direccion' => "Dirección de prueba número $i",
                    'rfc' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray(),

        ]);
    }
}
