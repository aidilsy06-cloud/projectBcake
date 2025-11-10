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
        // ===========================================
        // Jalankan seeder lain (Store & Product)
        // ===========================================
        $this->call([
            StoreSeeder::class,   // pastikan file StoreSeeder sudah ada
            ProductSeeder::class, // pastikan file ProductSeeder sudah ada
        ]);

        // ===========================================
        // Users sample (role-based)
        // ===========================================

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@bcake.local'],
            [
                'name'              => 'B’cake Admin',
                'password'          => Hash::make('password'), // login: admin@bcake.local / password
                'role'              => 'admin',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]
        );

        // Penjual (seller)
        User::updateOrCreate(
            ['email' => 'seller@bcake.local'],
            [
                'name'              => 'B’cake Seller',
                'password'          => Hash::make('password'), // seller@bcake.local / password
                'role'              => 'seller',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]
        );

        // Pembeli (buyer)
        User::updateOrCreate(
            ['email' => 'buyer@bcake.local'],
            [
                'name'              => 'B’cake Buyer',
                'password'          => Hash::make('password'), // buyer@bcake.local / password
                'role'              => 'buyer',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]
        );
    }
}
