<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin
        $admin = Admin::first();

        if (!$admin) {
            $this->command->warn('No admin found. Please run AdminSeeder first.');
            return;
        }

        // Create demo products
        $products = [
            [
                'name' => 'Premium Arabica Blend',
                'description' => 'A rich and smooth blend of premium Arabica beans, roasted to perfection. Notes of chocolate and caramel with a hint of vanilla.',
                'roast_level' => 'Medium',
                'origin' => 'Blend',
                'price' => 24.99,
                'stock' => 50,
                'image' => null,
            ],
            [
                'name' => 'Ethiopian Yirgacheffe',
                'description' => 'Single-origin Ethiopian coffee with bright acidity and floral notes. Perfect for those who enjoy a light, fruity cup.',
                'roast_level' => 'Light',
                'origin' => 'Ethiopia',
                'price' => 29.99,
                'stock' => 30,
                'image' => null,
            ],
            [
                'name' => 'Colombian Supremo',
                'description' => 'Full-bodied Colombian coffee with balanced flavor and mild acidity. A classic choice for daily brewing.',
                'roast_level' => 'Medium',
                'origin' => 'Colombia',
                'price' => 22.99,
                'stock' => 75,
                'image' => null,
            ],
            [
                'name' => 'Dark Roast Espresso',
                'description' => 'Bold and intense dark roast, perfect for espresso lovers. Rich, smoky flavor with low acidity.',
                'roast_level' => 'Dark',
                'origin' => 'Blend',
                'price' => 26.99,
                'stock' => 40,
                'image' => null,
            ],
            [
                'name' => 'Hawaiian Kona Blend',
                'description' => 'Exclusive Hawaiian Kona coffee with smooth, buttery texture and nutty undertones. Limited availability.',
                'roast_level' => 'Medium',
                'origin' => 'Hawaii',
                'price' => 49.99,
                'stock' => 15,
                'image' => null,
            ],
            [
                'name' => 'Organic Decaf',
                'description' => 'Naturally decaffeinated organic coffee. All the flavor without the caffeine. Swiss water process.',
                'roast_level' => 'Medium',
                'origin' => 'Blend',
                'price' => 27.99,
                'stock' => 35,
                'image' => null,
            ],
        ];

        $createdCount = 0;
        foreach ($products as $productData) {
            // Check if product already exists
            $existing = Product::where('name', $productData['name'])
                ->where('admin_id', $admin->admin_id)
                ->first();

            if ($existing) {
                continue;
            }

            Product::create([
                'admin_id' => $admin->admin_id,
                ...$productData,
            ]);
            $createdCount++;
        }

        if ($createdCount > 0) {
            $this->command->info("Created {$createdCount} new products");
        } else {
            $this->command->info('All products already exist');
        }

        $this->command->info('Created ' . count($products) . ' demo products');
    }
}
