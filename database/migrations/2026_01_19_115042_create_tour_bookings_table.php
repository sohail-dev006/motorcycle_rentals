<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name');
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('motorcycle_id')->nullable()->constrained()->nullOnDelete();

            $table->date('pick_date');

            $table->enum('status', ['pending','approved','cancelled'])->default('pending');

            $table->decimal('group_price', 10, 2)->default(0);
            $table->decimal('private_price', 10, 2)->default(0);
            $table->decimal('passenger_price', 10, 2)->default(0);

            $table->decimal('vat', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_bookings');
    }
};
