<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'tour_id',
        'motorcycle_id',
        'pick_date',
        'status',
        'group_price',
        'private_price',
        'passenger_price',
        'vat',
        'total_price',
        'description',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
