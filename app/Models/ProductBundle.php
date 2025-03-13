<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductBundle extends Model
{
    use HasFactory;

    protected   $table      =   'product_bundles';
    protected   $guarded    =   ['id'];

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bundle_product','bundle_id','product_id');
    }
}
