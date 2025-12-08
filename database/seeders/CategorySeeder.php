<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed or assign categories without factories.
     */
    public function run(): void
    {
        $categories = [
            'Jamu Tradisional',
            'Suplemen Alami',
            'Madu & Propolis',
            'Teh & Infus Herbal',
            'Minyak Atsiri',
            'Aromaterapi',
        ];

        $products = Product::all();

        if ($products->count() === 0) {
            // Create sample products if none exist
            foreach ($categories as $idx => $cat) {
                Product::create([
                    'name' => $cat . ' Sample ' . ($idx + 1),
                    'slug' => Str::slug($cat . '-sample-' . ($idx + 1) . '-' . uniqid()),
                    'description' => 'Produk sample kategori ' . $cat,
                    'price' => 50000 + ($idx * 10000),
                    'stock' => 50,
                    'category' => $cat,
                    'image' => null,
                ]);
            }
        } else {
            // Assign categories round-robin to existing products
            foreach ($products as $i => $product) {
                $product->update(['category' => $categories[$i % count($categories)]]);
            }
        }
    }
}

