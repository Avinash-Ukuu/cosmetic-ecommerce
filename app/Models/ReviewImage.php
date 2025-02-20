<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewImage extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];

    public function review():BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
