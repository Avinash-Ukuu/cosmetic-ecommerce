<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\ReviewImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function reviewImages():HasMany
    {
        return $this->hasMany(ReviewImage::class);
    }
}
