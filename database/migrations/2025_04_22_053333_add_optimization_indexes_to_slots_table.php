<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->index(['doctor_id', 'start_time', 'is_booked']);
            $table->index(['is_auto_generated', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->index(['doctor_id', 'day', 'is_active']);
        });
    }
};
