<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Product;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            Inventory::create([
                'product_id' => $product->id,
                'location' => 'Main Warehouse',
                'stock' => rand(50, 200),
                'cost' => rand(1000, 5000),
                'lot' => 'LOT-' . strtoupper(substr(md5($product->id), 0, 6)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

