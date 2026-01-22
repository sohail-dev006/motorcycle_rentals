<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [

        //  PERSONAL INFORMATION 
        'first_name',
        'last_name',
        'dob',
        'zip',
        'mobile',
        'email',
        'city',
        'country',
        'permanent_address',

        //  VISITOR ADDRESS 
        'hotel_name',
        'room_no',
        'visitor_city',
        'visitor_phone',
        'uae_address',
        'uae_city',             

        //  PASSPORT / ID 
        'nationality',
        'passport_no',
        'passport_expiry',
        'age',

        //  EMERGENCY 
        'emergency_name',
        'emergency_relation',
        'emergency_city',
        'emergency_phone',
        'emergency_address',

        //  LICENSE 
        'license_no',
        'license_country',
        'license_expiry',
        'international_license_no',

        //  PAYMENT 
        'card_type',
        'card_number',          
        'card_last_four',
        'card_expiry',

        //  IMAGE 
        'image'
    ];

    protected $casts = [
        'dob'             => 'date',
        'passport_expiry' => 'date',
        'license_expiry'  => 'date',
    ];
}
