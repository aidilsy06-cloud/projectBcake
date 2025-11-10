<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Sweet Delights','Cakes & Bakes','Pastry Corner'];
        foreach ($names as $name) {
            Store::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => 'Toko '.$name.' — kue segar setiap hari.']
            );
        }
    }
}
