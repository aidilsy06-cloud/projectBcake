<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Store;

class ProductSeeder extends Seeder
{
    /**
     * Seed example products for B'cake (linked to a Store).
     */
    public function run(): void
    {
        // Pastikan ada store. Jika belum ada, buat satu default.
        $store = Store::first();
        if (! $store) {
            $store = Store::firstOrCreate(
                ['slug' => 'bcake-official'],
                [
                    'name'        => "B’cake Official",
                    'logo'        => null,
                    'description' => 'Toko resmi B’cake untuk semua varian cupcake, brownies, dan cheesecake.',
                ]
            );
        }

        $items = [
            [
                'name'        => 'Cherry Deluxe Cupcake',
                'slug'        => 'cherry-deluxe-cupcake',
                'price'       => 26000,
                'stock'       => 20,
                'image_url'   => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=1200',
                'description' => 'Cupcake cokelat lembut dengan ganache & ceri segar.',
            ],
            [
                'name'        => 'Truffle Brownies',
                'slug'        => 'truffle-brownies',
                'price'       => 28000,
                'stock'       => 30,
                'image_url'   => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476e?q=80&w=1200',
                'description' => 'Brownies premium rasa truffle: fudgy, intense, dan wangi.',
            ],
            [
                'name'        => 'Icing Mist Cheesecake',
                'slug'        => 'icing-mist-cheesecake',
                'price'       => 32000,
                'stock'       => 15,
                'image_url'   => 'https://images.unsplash.com/photo-1551024709-8f23befc6cf7?q=80&w=1200',
                'description' => 'Cheesecake creamy dengan sentuhan icing lembut warna mist.',
            ],
            [
                'name'        => 'Bitter Cocoa Muffin',
                'slug'        => 'bitter-cocoa-muffin',
                'price'       => 22000,
                'stock'       => 24,
                'image_url'   => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1200',
                'description' => 'Muffin cokelat pekat dengan taburan choco chips.',
            ],
        ];

        foreach ($items as $i) {
            // Jaga-jaga: jika slug tidak diset, generate dari name
            $i['slug'] = $i['slug'] ?? Str::slug($i['name']);

            // Tambahkan foreign key store
            $i['store_id'] = $store->id;

            // Kalau slug sudah ada -> update, kalau belum -> create
            Product::updateOrCreate(['slug' => $i['slug']], $i);
        }
    }
}
