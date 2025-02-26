<?php

namespace App\Http\Controllers\api;

use Stripe\Stripe;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Mail\OrderStatusMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

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
        Mail::to([$order->customer->email,'glamifyy.ae@gmail.com'])->send(new OrderStatusMail($order, 'paid'));

        return response()->json(['message' => 'Payment successful!'], 200);
    }

    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['payment_status' => 'cancel']);
        Mail::to([$order->customer->email,'glamifyy.ae@gmail.com'])->send(new OrderStatusMail($order, 'canceled'));

        return response()->json(['message' => 'Payment cancelled'], 200);
    }
}
