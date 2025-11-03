<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Seed produk contoh
        $this->call([
            ProductSeeder::class,
        ]);

        // ✅ (Opsional) Buat 1 user contoh untuk login admin
        if (!User::where('email', 'admin@bcake.local')->exists()) {
            User::factory()->create([
                'name'     => 'B’cake Admin',
                'email'    => 'admin@bcake.local',
                'password' => bcrypt('password'), // login: admin@bcake.local / password
            ]);
        }
    }
}
