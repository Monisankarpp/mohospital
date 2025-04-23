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
            $table->dropForeign(['doctor_department_id']);
            $table->dropColumn('doctor_department_id');
            $table->boolean('is_auto_generated')->default(false);
            $table->boolean('is_recurring')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
