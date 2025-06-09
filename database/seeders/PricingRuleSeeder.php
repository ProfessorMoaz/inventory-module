<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingRule;
use App\Models\Product;
use Carbon\Carbon;

class PricingRuleSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Time-based rule (10% off during weekdays 9AM–5PM)
            PricingRule::create([
                'product_id' => $product->id,
                'type' => 'time',
                'condition' => json_encode([
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'start' => '09:00',
                    'end' => '17:00',
                ]),
                'discount' => 10,
                'precedence' => 1,
                'valid_from' => Carbon::now()->subDays(10),
                'valid_to' => Carbon::now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Quantity-based rule (15% off if quantity >= 10)
            PricingRule::create([
                'product_id' => $product->id,
                'type' => 'quantity',
                'condition' => json_encode([
                    'min_qty' => 10
                ]),
                'discount' => 15,
                'precedence' => 2,
                'valid_from' => Carbon::now()->subDays(10),
                'valid_to' => Carbon::now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

