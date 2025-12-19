<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Componentes'],
            ['name' => 'Accesorios'],
            ['name' => 'Periféricos'],
            ['name' => 'Software'],
            ['name' => 'Refacciones'],
            ['name' => 'Otros'],
        ]);
    }
}
