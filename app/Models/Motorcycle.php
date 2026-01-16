<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'code', 'quantity', 'sort_order',
        'brand_id', 'status', 'visibility',
        'base_price', 'extra_price', 'description', 'image',
    ];
}
