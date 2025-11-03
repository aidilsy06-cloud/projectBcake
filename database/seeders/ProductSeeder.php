<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Seed example products for B'cake.
     */
    public function run(): void
    {
        $items = [
            [
                'name'        => 'Cherry Deluxe Cupcake',
                'slug'        => 'cherry-deluxe-cupcake',
                'price'       => 26000,
                'stock'       => 20,
                'image_url'   => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=1200',
                'description' => 'Cupcake cokelat lembut dengan ganache & ceri segar.'
            ],
            [
                'name'        => 'Truffle Brownies',
                'slug'        => 'truffle-brownies',
                'price'       => 28000,
                'stock'       => 30,
                'image_url'   => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476e?q=80&w=1200',
                'description' => 'Brownies premium rasa truffle: fudgy, intense, dan wangi.'
            ],
            [
                'name'        => 'Icing Mist Cheesecake',
                'slug'        => 'icing-mist-cheesecake',
                'price'       => 32000,
                'stock'       => 15,
                'image_url'   => 'https://images.unsplash.com/photo-1551024709-8f23befc6cf7?q=80&w=1200',
                'description' => 'Cheesecake creamy dengan sentuhan icing lembut warna mist.'
            ],
            [
                'name'        => 'Bitter Cocoa Muffin',
                'slug'        => 'bitter-cocoa-muffin',
                'price'       => 22000,
                'stock'       => 24,
                'image_url'   => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1200',
                'description' => 'Muffin cokelat pekat dengan taburan choco chips.'
            ],
        ];

        foreach ($items as $i) {
            // update jika slug sudah ada, kalau belum otomatis create
            Product::updateOrCreate(['slug' => $i['slug']], $i);
        }
    }
}
