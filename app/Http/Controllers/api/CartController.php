<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user       = Auth::user();

        $productId  = $request->product_id;
        $quantity   = $request->quantity ?? 1;
        $product    = Product::where('id', $productId)->where('publish_type', 'publish')->first();

        if (!$product) {
            return response()->json(['message' => 'Product not available or not published'], 404);
        }

        $cartItem   = Cart::where('customer_id', $user->customer->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
            $message = 'Product quantity updated in cart';
        } else {
            // Add new product to cart
            $cartItem = new Cart();
            $cartItem->customer_id = $user->customer->id;
            $cartItem->product_id  = $productId;
            $cartItem->quantity    = $quantity;
            $cartItem->save();
            $message = 'Product added to cart';
        }

        return response()->json(['message' => $message, 'cart' => $cartItem], 201);
    }

    public function removeFromCart(Request $request)
    {
        $user       =   Auth::user();
        $productId  =   $request->product_id;

        $cartItem   =   Cart::where('customer_id', $user->customer->id)->where('product_id', $productId)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Product not found in cart'], 404);
        }
        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart'], 204);
    }

    public function getCart()
    {
        $user       =   Auth::user();
        $cartItems  =   Cart::where('customer_id', $user->customer->id)->with('product.productImages')->get();

        return response()->json([
            'message' => 'Cart items retrieved successfully',
            'cart' => $cartItems
        ], 200);
    }

}
