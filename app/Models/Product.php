<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Category;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value),
        );
    }

    public function productImages(): HasMany
    {
        return  $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlistedByCustomers()
    {
        return $this->belongsToMany(Customer::class, 'wishlists', 'product_id', 'customer_id')->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
