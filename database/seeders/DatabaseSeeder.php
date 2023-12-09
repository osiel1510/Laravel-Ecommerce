<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ejecuta el seeder del usuario administrador
        $this->call(AdminUserSeeder::class);
    }
}
