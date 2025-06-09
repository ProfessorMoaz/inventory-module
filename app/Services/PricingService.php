<?php

namespace App\Services;

use App\Models\PricingRule;
use Carbon\Carbon;

class PricingService
{
    /**
     * Calculate final price for a product based on pricing rules.
     */
    public function calculateFinalPrice($product, $basePrice, $quantity)
    {
        $now = Carbon::now();
        $applicableRules = PricingRule::where('product_id', $product->id)
            ->where('valid_from', '<=', $now)
            ->where('valid_to', '>=', $now)
            ->orderBy('precedence', 'desc')
            ->get();

        $finalPrice = $basePrice;

        foreach ($applicableRules as $rule) {
            if ($rule->type === 'time') {
                $condition = json_decode($rule->condition, true); // e.g. {"days": ["Saturday", "Sunday"], "start": "08:00", "end": "20:00"}

                if (in_array($now->format('l'), $condition['days'] ?? [])) {
                    $start = Carbon::createFromFormat('H:i', $condition['start']);
                    $end = Carbon::createFromFormat('H:i', $condition['end']);

                    if ($now->between($start, $end)) {
                        $finalPrice -= ($finalPrice * ($rule->discount / 100));
                        break; // apply highest precedence rule only
                    }
                }
            }

            if ($rule->type === 'quantity') {
                $condition = json_decode($rule->condition, true); // e.g. {"min_qty": 10}
                if ($quantity >= ($condition['min_qty'] ?? 0)) {
                    $finalPrice -= ($finalPrice * ($rule->discount / 100));
                    break;
                }
            }
        }

        return round($finalPrice, 2);
    }
}
