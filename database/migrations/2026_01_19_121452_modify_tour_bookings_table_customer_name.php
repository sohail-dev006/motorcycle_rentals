<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('tour_bookings', 'customer_name')) {
                $table->string('customer_name')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('tour_bookings', 'customer_name')) {
                $table->string('customer_name')->nullable(false)->change();
            }
        });
    }
};
