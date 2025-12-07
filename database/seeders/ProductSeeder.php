<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Smartphone Pro Max',
                'slug' => 'smartphone-pro-max',
                'description' => 'Latest flagship smartphone with amazing camera and battery life.',
                'price' => 12000000,
                'stock' => 50,
                'image' => null, // You can add generic placeholder URLs if needed, but null is safe
            ],
            [
                'name' => 'Laptop Ultra Slim',
                'slug' => 'laptop-ultra-slim',
                'description' => 'Lightweight laptop with powerful performance for professionals.',
                'price' => 15000000,
                'stock' => 30,
                'image' => null,
            ],
            [
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'Noise cancelling headphones for immersive sound experience.',
                'price' => 2500000,
                'stock' => 100,
                'image' => null,
            ],
            [
                'name' => 'Smart Watch Series 5',
                'slug' => 'smart-watch-series-5',
                'description' => 'Track your fitness and health with this advanced smartwatch.',
                'price' => 3000000,
                'stock' => 75,
                'image' => null,
            ],
            [
                'name' => 'Gaming Mouse',
                'slug' => 'gaming-mouse',
                'description' => 'High precision gaming mouse with RGB lighting.',
                'price' => 500000,
                'stock' => 200,
                'image' => null,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'slug' => 'mechanical-keyboard',
                'description' => 'Tactile mechanical keyboard for typing and gaming enthusiasts.',
                'price' => 1200000,
                'stock' => 60,
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
