<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            /* PERSONAL */
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob')->nullable();
            $table->string('zip')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('city');
            $table->string('country');
            $table->text('permanent_address')->nullable();

            /* VISITOR */
            $table->string('hotel_name')->nullable();
            $table->string('room_no')->nullable();
            $table->string('visitor_city')->nullable();
            $table->string('visitor_phone')->nullable();
            $table->text('uae_address')->nullable();
            $table->string('uae_city')->nullable(); 

            /* PASSPORT */
            $table->string('nationality');
            $table->string('passport_no');
            $table->date('passport_expiry');
            $table->unsignedTinyInteger('age');

            /* EMERGENCY */
            $table->string('emergency_name')->nullable();
            $table->string('emergency_relation')->nullable();
            $table->string('emergency_city')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->text('emergency_address')->nullable();

            /* LICENSE */
            $table->string('license_no')->nullable();
            $table->string('license_country')->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('international_license_no')->nullable();

            /* PAYMENT */
            $table->string('card_type')->nullable();
            $table->string('card_number')->nullable();      
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_expiry')->nullable();

            /* IMAGE */
            $table->string('image')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
