<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses():HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'customer_id', 'product_id')->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}
