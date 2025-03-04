<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
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
        $cartItems = Cart::where('customer_id', $user->customer->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty!'], 400);
        }

        DB::beginTransaction();
        try {
            // Calculate total amount
            $totalAmount    = $cartItems->sum(fn($item) => $item->product->sale_price * $item->quantity);

            $discountAmount = 0;
            $coupon         = null;
            $couponId       = null;

            if ($request->has('coupon_code')) {
                $coupon     = Coupon::where('code', $request->coupon_code)
                                ->where('expiry_date', '>=', now())
                                ->first();

                if ($coupon) {
                    $couponId = $coupon->id;

                    if ($totalAmount < $coupon->minimum_purchase) {
                        return response()->json(['error' => 'Minimum purchase amount is required!'], 400);
                    }

                    // Calculate discount
                    if ($coupon->discount_type === 'fixed') {
                        $discountAmount = $coupon->discount;
                    } elseif ($coupon->discount_type === 'percentage') {
                        $discountAmount = ($totalAmount * $coupon->discount) / 100;
                    }

                    // Ensure discount is not greater than total amount
                    $discountAmount = min($discountAmount, $totalAmount);

                } else {
                    return response()->json(['error' => 'Invalid or expired coupon code!'], 400);
                }
            }

            $finalAmount = $totalAmount - $discountAmount;
            // Create order
            $order                  =       new Order();
            $order->user_id         =       $user->id;
            $order->total_amount    =       $finalAmount;
            $order->discount_amount =       $discountAmount;
            $order->coupon_id       =       $couponId;
            $order->status          =       'pending';
            $order->address_id      =       $request->address_id;
            $order->payment_status  =       'unpaid';
            $order->country_id            =       $request->country_id;
            $order->city_id               =       $request->city_id;
            $order->shipping_option_id    =       $request->shipping_option_id;
            $order->order_created_at  =     now();
            $order->save();
            // Insert order items
            foreach ($cartItems as $cartItem) {

                $orderItem              =       new OrderItem();
                $orderItem->order_id    =       $order->id;
                $orderItem->product_id  =       $cartItem->product_id;
                $orderItem->quantity    =       $cartItem->quantity;
                $orderItem->price       =       $cartItem->product->sale_price;
                $orderItem->save();

                // Reduce stock
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->update(['quantity' => $product->quantity - $cartItem->quantity]);
                }
            }
            // Reduce coupon usage limit if applied
            if ($coupon) {
                $coupon->decrement('usage_limit');
            }
            // Clear cart after order placement
            Cart::where('customer_id', $user->customer->id)->delete();

            DB::commit();

            return response()->json(['message' => 'Order placed successfully!', 'order_id' => $order->id], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong!', 'message' => $e->getMessage()], 500);
        }
    }

    public function getOrder()
    {
        $user       =   Auth::user();

        if (empty($user)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $orders     =   Order::with(['orderItems.product.productImages'])
                                ->where('user_id', $user->id)
                                ->orderBy('order_created_at', 'desc')
                                ->get();

        return response()->json([
                        'status' => true,
                        'message' => 'Order history fetched successfully',
                        'orders' => $orders
                    ], 200);
    }
}
