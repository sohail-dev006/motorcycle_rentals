<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorcycleBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'motorcycle_id',
        'status',
        'pick_date',
        'drop_date',
        'pick_time',
        'drop_time',
        'addons',
        'description'
    ];

    protected $casts = [
        'addons' => 'array',
        'pick_date' => 'date',
        'drop_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
