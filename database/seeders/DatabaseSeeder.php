<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =======================================================
        // 1. Jalankan semua seeder yang diperlukan (Store & Product)
        // =======================================================
        $this->call([
            StoreSeeder::class,     // untuk daftar toko default
            ProductSeeder::class,   // untuk produk contoh (opsional)
        ]);

        // =======================================================
        // 2. Seed User (Admin, Seller, Buyer)
        // =======================================================

        // ---- Admin ----
        User::updateOrCreate(
            ['email' => 'admin@bcake.local'],
            [
                'name'              => 'B’cake Admin',
                'password'          => Hash::make('password'), 
                'role'              => 'admin',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]
        );

        // ---- Penjual / Seller ----
        User::updateOrCreate(
            ['email' => 'seller@bcake.local'],
            [
                'name'              => 'B’cake Seller',
                'password'          => Hash::make('password'),
                'role'              => 'seller',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]
        );

        // ---- Pembeli / Buyer ----
        User::updateOrCreate(
            ['email' => 'buyer@bcake.local'],
            [
                'name'              => 'B’cake Buyer',
                'password'          => Hash::make('password'),
                'role'              => 'buyer',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]
        );
    }
}
