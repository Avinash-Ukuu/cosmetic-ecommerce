<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLogs extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];
    protected $table    =   'activity_logs';

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => now()->parse($value)->format("M d Y H:i:s"),
        );
    }
}
