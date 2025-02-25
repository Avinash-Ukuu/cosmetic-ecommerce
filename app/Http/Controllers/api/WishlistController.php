<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggleWishlist(Request $request)
    {
        $user           = User::with('customer')->find($request->user_id);

        $productId      = $request->product_id;
        $product        = Product::where('id', $productId)->where('publish_type', 'publish')->first();

        if (!$product) {
            return response()->json(['message' => 'Product not available or not published'], 404);
        }

        $isInWishlist   = $user->customer->wishlistProducts()->where('product_id', $productId)->exists();

        if ($isInWishlist) {
            $user->customer->wishlistProducts()->detach($productId);

            return response()->json(['message' => 'Product removed from wishlist'], 200);
        } else {
            $user->customer->wishlistProducts()->attach($productId);

            return response()->json(['message' => 'Product added to wishlist'], 200);
        }
    }

    public function getWishlist()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

         $wishlistProducts = $user->customer->wishlistProducts()->where('publish_type', 'publish')->get();

        return response()->json([
            'message' => 'Customer wishlist retrieved successfully',
            'wishlist' => $wishlistProducts
        ], 200);
    }
}
