<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $user       = Auth::user();

        // Fetch cart items for the user
        $cartItems = Cart::where('customer_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty!'], 400);
        }

        DB::beginTransaction();
        try {
            // Calculate total amount
            $totalAmount = $cartItems->sum(fn($item) => $item->product->sale_price * $item->quantity);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                // 'order_number' => 'ORD-' . Str::random(10),
                'total_amount' => $totalAmount,
                'status' => 'pending', // Default status
                'address_id' => $request->address_id, // Address provided by the user
                'payment_status' => 'unpaid',
                'order_created_at' => now()
            ]);

            // Insert order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->sale_price
                ]);

                // Reduce stock
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->update(['stock' => $product->stock - $cartItem->quantity]);
                }
            }

            // Clear cart after order placement
            Cart::where('customer_id', $user->id)->delete();

            DB::commit();

            return response()->json(['message' => 'Order placed successfully!', 'order_id' => $order->id], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
}
