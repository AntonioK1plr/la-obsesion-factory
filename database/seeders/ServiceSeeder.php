<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicios')->insert([

            // 1
            [
                'nombre' => 'Cambio de pasta térmica',
                'categoria' => 'Mantenimiento',
                'costo' => 350,
                'tiempo_estimado' => 120,
                'descripcion' => 'Se limpia a fondo el procesador (CPU) y el disipador para retirar la pasta vieja y seca, usando alcohol isopropílico y un paño sin pelusa, para luego aplicar una nueva capa de pasta térmica de alta calidad en el centro del procesador (tamaño de un chícharo) y volver a montar el disipador sin deslizarlo, asegurando una transferencia de calor óptima y evitando sobrecalentamientos, mejorando rendimiento y vida útil del equipo.',
                'requisitos' => "Pasta térmica nueva: Utiliza una pasta de calidad reconocida para asegurar una buena transferencia de calor y durabilidad.\n
Alcohol isopropílico: Esencial para limpiar los residuos de la pasta térmica vieja, ya que se evapora sin dejar residuos.\n
Paño de microfibra o pañuelos sin pelusa: Necesarios para limpiar CPU y disipador.\n
Herramientas para desmontar: Juego de destornilladores adecuados para el equipo.\n
Guantes antiestáticos (opcional): Ayudan a prevenir daños por descarga electrostática.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
    'nombre' => 'Limpieza interna de PC',
    'categoria' => 'Limpieza',
    'costo' => 400,
    'tiempo_estimado' => 90,
    'descripcion' => 'Limpieza completa de componentes internos como ventiladores, disipadores, placa base y fuente de poder, eliminando polvo acumulado que afecta el flujo de aire y provoca sobrecalentamiento.',
    'requisitos' => 'Aire comprimido, brocha antiestática, paño de microfibra, destornilladores.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Diagnóstico general de equipo',
    'categoria' => 'Diagnóstico',
    'costo' => 250,
    'tiempo_estimado' => 60,
    'descripcion' => 'Revisión completa del equipo para detectar fallas de hardware o software, verificando funcionamiento de componentes, temperaturas y errores del sistema.',
    'requisitos' => 'Equipo completo, acceso al sistema o BIOS.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Formateo e instalación de Windows',
    'categoria' => 'Instalación',
    'costo' => 600,
    'tiempo_estimado' => 150,
    'descripcion' => 'Respaldo de información (si aplica), formateo del disco e instalación limpia del sistema operativo Windows con controladores básicos.',
    'requisitos' => 'Licencia de Windows, respaldo previo de información.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Instalación de programas básicos',
    'categoria' => 'Instalación',
    'costo' => 300,
    'tiempo_estimado' => 45,
    'descripcion' => 'Instalación y configuración de programas esenciales como navegador, antivirus, suite ofimática y reproductores multimedia.',
    'requisitos' => 'Conexión a internet, licencias si aplica.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Reemplazo de disco duro por SSD',
    'categoria' => 'Reparación',
    'costo' => 500,
    'tiempo_estimado' => 120,
    'descripcion' => 'Sustitución del disco duro tradicional por una unidad SSD para mejorar el rendimiento del sistema, incluyendo configuración básica.',
    'requisitos' => 'SSD compatible, respaldo de información.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Ampliación de memoria RAM',
    'categoria' => 'Instalación',
    'costo' => 350,
    'tiempo_estimado' => 60,
    'descripcion' => 'Instalación de módulos de memoria RAM adicionales y verificación de compatibilidad y correcto funcionamiento.',
    'requisitos' => 'Memoria RAM compatible con el equipo.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Eliminación de virus y malware',
    'categoria' => 'Reparación',
    'costo' => 450,
    'tiempo_estimado' => 120,
    'descripcion' => 'Análisis profundo del sistema para detectar y eliminar virus, spyware y malware que afectan el rendimiento y la seguridad.',
    'requisitos' => 'Acceso al sistema, conexión a internet.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Optimización del sistema operativo',
    'categoria' => 'Mantenimiento',
    'costo' => 300,
    'tiempo_estimado' => 60,
    'descripcion' => 'Optimización de arranque, servicios y configuraciones del sistema para mejorar el rendimiento general del equipo.',
    'requisitos' => 'Acceso administrativo al sistema.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Reparación de arranque de Windows',
    'categoria' => 'Reparación',
    'costo' => 400,
    'tiempo_estimado' => 90,
    'descripcion' => 'Corrección de errores que impiden el arranque del sistema operativo mediante herramientas de recuperación.',
    'requisitos' => 'Medio de instalación de Windows.',
    'created_at' => now(),
    'updated_at' => now(),
],

[
    'nombre' => 'Configuración de red e internet',
    'categoria' => 'Mantenimiento',
    'costo' => 280,
    'tiempo_estimado' => 45,
    'descripcion' => 'Configuración de red cableada o inalámbrica, resolución de problemas de conectividad y ajustes de seguridad básicos.',
    'requisitos' => 'Router, credenciales de red.',
    'created_at' => now(),
    'updated_at' => now(),
],


        ]);
    }
}
