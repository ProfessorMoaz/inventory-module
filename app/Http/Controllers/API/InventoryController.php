<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\PricingService;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * GET /api/inventory
     * Paginated inventory list with filters
     */
    public function index(Request $request)
    {
        $query = Inventory::with('product');

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        return response()->json($query->paginate(10));
    }

    /**
     * GET /api/inventory/{id}
     * Show inventory item with current price
     */
    public function show($id, PricingService $pricingService)
    {
        $inventory = Inventory::with('product')->findOrFail($id);

        $product = $inventory->product;
        $basePrice = $product->base_price ?? 100; 
        $finalPrice = $pricingService->calculateFinalPrice($product, $basePrice, 1);

        return response()->json([
            'inventory' => $inventory,
            'base_price' => $basePrice,
            'final_price' => $finalPrice
        ]);
    }

    /**
     * PUT /api/inventory/{id}
     * Update stock
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'stock' => 'required|integer|min:0'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $inventory = Inventory::findOrFail($id);
        $inventory->stock = $request->stock;
        $inventory->save();

        return response()->json([
            'message' => 'Inventory updated successfully',
            'inventory' => $inventory
        ]);
    }
}
