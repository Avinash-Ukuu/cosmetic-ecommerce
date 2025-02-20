<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $table        =   'payments';
    protected $guarded      =   ['id'];

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
