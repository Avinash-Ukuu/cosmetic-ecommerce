<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Country;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\ShippingOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table        =   'orders';
    protected $guarded      =   ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_number = self::generateOrderNumber();
        });
    }

    public static function generateOrderNumber()
    {
        $latestOrder    = self::latest('id')->first();
        if ($latestOrder && preg_match('/COS-(\d+)/', $latestOrder->order_number, $matches)) {
            $latestId = intval($matches[1]);
        } else {
            $latestId = 1000;
        }

        return 'COS-' . ($latestId + 1);
    }

    protected function orderCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => now()->parse($value)->format("M d Y H:i:s"),
        );
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payment():HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function address():BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function coupon():BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function shippingOption():BelongsTo
    {
        return $this->belongsTo(ShippingOption::class);
    }
}
