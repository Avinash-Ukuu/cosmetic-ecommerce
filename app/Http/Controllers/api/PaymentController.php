<?php

namespace App\Http\Controllers\api;

use Stripe\Stripe;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $order = Order::findOrFail($request->order_id);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Order #' . $order->order_number],
                    'unit_amount' => $order->total_amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['order' => $order->id]),
            'cancel_url' => route('payment.cancel', ['order' => $order->id]),
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['payment_status' => 'paid']);
        return redirect('/orders')->with('success', 'Payment successful!');
    }

    public function cancel($orderId)
    {
        return redirect('/orders')->with('error', 'Payment cancelled.');
    }
}
