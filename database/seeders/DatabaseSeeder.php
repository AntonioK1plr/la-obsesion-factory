<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\VentasSeeder;
use Database\Seeders\ComprasSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            VentasSeeder::class,
            ComprasSeeder::class,



        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
