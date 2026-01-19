<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('motorcycle_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade');

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            $table->date('pick_date');
            $table->date('drop_date');
            $table->time('pick_time');
            $table->time('drop_time');

            $table->json('addons')->nullable(); 

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motorcycle_bookings');
    }
};
