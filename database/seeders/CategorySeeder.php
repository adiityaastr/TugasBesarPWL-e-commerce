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

        // Jika tidak ada produk, buat sample herbal
        if ($products->count() === 0) {
            $samples = [
                ['name' => 'Jamu Beras Kencur', 'price' => 32000, 'category' => 'Jamu Tradisional'],
                ['name' => 'Propolis Extract', 'price' => 88000, 'category' => 'Madu & Propolis'],
                ['name' => 'Teh Bunga Telang', 'price' => 27000, 'category' => 'Teh & Infus Herbal'],
                ['name' => 'Minyak Serai Wangi', 'price' => 39000, 'category' => 'Minyak Atsiri'],
                ['name' => 'Kapsul Pegagan', 'price' => 62000, 'category' => 'Suplemen Alami'],
                ['name' => 'Diffuser Blend Relax', 'price' => 75000, 'category' => 'Aromaterapi'],
            ];

            foreach ($samples as $idx => $sample) {
                Product::create([
                    'name' => $sample['name'],
                    'slug' => Str::slug($sample['name'] . '-' . uniqid()),
                    'description' => 'Produk herbal kategori ' . $sample['category'],
                    'price' => $sample['price'],
                    'stock' => 60,
                    'category' => $sample['category'],
                    'image' => null,
                ]);
            }
        } else {
            // Hanya isi kategori yang masih null agar tidak menimpa kategori yang sudah diset
            foreach ($products as $i => $product) {
                if (empty($product->category)) {
                    $product->update(['category' => $categories[$i % count($categories)]]);
                }
            }
        }
    }
}

