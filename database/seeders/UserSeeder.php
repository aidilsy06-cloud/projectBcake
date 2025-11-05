<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Bcake',
            'email' => 'admin@bcake.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
