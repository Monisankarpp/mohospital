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
        Schema::table('doctor_schedules', function (Blueprint $table) {
            $table->enum('day_of_week', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ])->after('doctor_id');

            $table->boolean('is_working')->default(true)->after('day_of_week');
            $table->integer('slot_duration')->default(30)->after('lunch_end');
            $table->integer('break_between_slots')->default(5)->after('slot_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_schedules', function (Blueprint $table) {
            $table->dropColumn(['day_of_week', 'is_working', 'slot_duration', 'break_between_slots']);
        });
    }
};
