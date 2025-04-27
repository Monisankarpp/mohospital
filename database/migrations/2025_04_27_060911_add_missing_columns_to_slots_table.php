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
            $table->enum('status', ['available', 'booked', 'cancelled', 'break'])
                ->default('available')
                ->after('is_booked');

            $table->boolean('is_lunch_break')
                ->default(false)
                ->after('status');

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->after('id'); // you can adjust after which column you prefer

            $table->dateTime('can_edit_until')
                ->nullable()
                ->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn(['status', 'is_lunch_break', 'appointment_id', 'can_edit_until']);
        });
    }
};
