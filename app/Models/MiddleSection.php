<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiddleSection extends Model
{
    use HasFactory;

    protected $table        =   'middle_sections';
    protected $guarded      =   ['id'];
}
