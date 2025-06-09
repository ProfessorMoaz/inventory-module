<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\AuditLog;
use App\Services\PricingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * POST /api/transactions
     * Safely process sale
     */
    public function store(Request $request, PricingService $pricingService)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:sale,restock',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $inventory = Inventory::where('product_id', $request->product_id)
                                  ->lockForUpdate()
                                  ->firstOrFail();

            if ($request->type === 'sale' && $inventory->stock < $request->quantity) {
                return response()->json(['message' => 'Insufficient stock'], 400);
            }

            $product = $inventory->product;
            $basePrice = $product->base_price;
            $finalPrice = $pricingService->calculateFinalPrice($product, $basePrice, $request->quantity);

            $transaction = Transaction::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'type' => $request->type,
                'status' => 'completed',
            ]);

            $oldStock = $inventory->stock;
            if ($request->type === 'sale') {
                $inventory->stock -= $request->quantity;
            } else {
                $inventory->stock += $request->quantity;
            }
            $inventory->save();

            AuditLog::create([
                'transaction_id' => $transaction->id,
                'changes' => json_encode([
                    'old_stock' => $oldStock,
                    'new_stock' => $inventory->stock,
                    'final_price' => $finalPrice,
                ])
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Transaction processed successfully',
                'transaction' => $transaction,
                'final_price' => $finalPrice,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Transaction failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
