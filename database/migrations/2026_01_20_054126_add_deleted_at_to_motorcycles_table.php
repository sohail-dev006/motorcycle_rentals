<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->softDeletes(); // deleted_at
        });
    }

    public function down()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

