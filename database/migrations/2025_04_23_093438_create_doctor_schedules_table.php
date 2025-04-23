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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('lunch_start')->nullable();
            $table->time('lunch_end')->nullable();
            $table->json('working_days');
            $table->json('breaks')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->date('valid_from');
            $table->date('valid_to');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
