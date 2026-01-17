<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relation with motorcycles
    public function motorcycles()
    {
        return $this->hasMany(Motorcycle::class);
    }
}
