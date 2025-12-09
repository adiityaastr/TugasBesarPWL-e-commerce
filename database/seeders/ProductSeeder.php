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
                'name' => 'Jamu Kunyit Asam',
                'slug' => 'jamu-kunyit-asam',
                'description' => 'Minuman herbal tradisional untuk menyegarkan tubuh dan membantu pencernaan.',
                'price' => 35000,
                'stock' => 80,
                'category' => 'Jamu Tradisional',
                'image' => null,
            ],
            [
                'name' => 'Madu Hutan Premium 500ml',
                'slug' => 'madu-hutan-premium-500ml',
                'description' => 'Madu murni dari hutan tropis, kaya enzim dan antioksidan.',
                'price' => 95000,
                'stock' => 60,
                'category' => 'Madu & Propolis',
                'image' => null,
            ],
            [
                'name' => 'Teh Hijau Daun Kelor',
                'slug' => 'teh-hijau-daun-kelor',
                'description' => 'Teh celup daun kelor tinggi antioksidan untuk stamina harian.',
                'price' => 28000,
                'stock' => 120,
                'category' => 'Teh & Infus Herbal',
                'image' => null,
            ],
            [
                'name' => 'Minyak Kayu Putih Aromaterapi',
                'slug' => 'minyak-kayu-putih-aromaterapi',
                'description' => 'Minyak kayu putih dengan aroma lembut untuk relaksasi dan kehangatan.',
                'price' => 42000,
                'stock' => 90,
                'category' => 'Minyak Atsiri',
                'image' => null,
            ],
            [
                'name' => 'Kapsul Temulawak',
                'slug' => 'kapsul-temulawak',
                'description' => 'Suplemen herbal temulawak membantu menjaga fungsi hati dan stamina.',
                'price' => 65000,
                'stock' => 150,
                'category' => 'Suplemen Alami',
                'image' => null,
            ],
            [
                'name' => 'Lotion Aromaterapi Lavender',
                'slug' => 'lotion-aromaterapi-lavender',
                'description' => 'Lotion dengan minyak esensial lavender untuk kulit lembap dan rileks.',
                'price' => 58000,
                'stock' => 70,
                'category' => 'Aromaterapi',
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
