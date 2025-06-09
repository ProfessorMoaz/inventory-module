<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'sku' => 'SKU-001',
                'name' => 'Wireless Mouse',
                'description' => 'Smooth ergonomic wireless mouse',
                'base_price' => 25.00,
            ],
            [
                'sku' => 'SKU-002',
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard with blue switches',
                'base_price' => 55.00,
            ],
            [
                'sku' => 'SKU-003',
                'name' => '1080p Webcam',
                'description' => 'HD webcam suitable for streaming and video calls',
                'base_price' => 45.00,
            ],
            [
                'sku' => 'SKU-004',
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub with HDMI and card reader',
                'base_price' => 35.00,
            ],
            [
                'sku' => 'SKU-005',
                'name' => 'External Hard Drive 1TB',
                'description' => 'Portable 1TB external HDD for backups',
                'base_price' => 60.00,
            ],
            [
                'sku' => 'SKU-006',
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminum laptop stand for better posture',
                'base_price' => 30.00,
            ],
            [
                'sku' => 'SKU-007',
                'name' => 'Bluetooth Headphones',
                'description' => 'Noise-cancelling over-ear Bluetooth headphones',
                'base_price' => 75.00,
            ],
            [
                'sku' => 'SKU-008',
                'name' => 'Smartphone Tripod',
                'description' => 'Flexible smartphone tripod for vlogging',
                'base_price' => 20.00,
            ],
            [
                'sku' => 'SKU-009',
                'name' => 'LED Desk Lamp',
                'description' => 'Dimmable LED lamp with USB charging port',
                'base_price' => 22.00,
            ],
            [
                'sku' => 'SKU-010',
                'name' => 'Wireless Charger Pad',
                'description' => 'Fast wireless charger for Qi-enabled devices',
                'base_price' => 28.00,
            ],
        ];
        
        foreach ($products as $product) {
            Product::create([
                'sku' => $product['sku'],
                'name' => $product['name'],
                'description' => $product['description'],
                'base_price' => $product['base_price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }        
    }
}
