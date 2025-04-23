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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected', 'rescheduled', 'completed', 'cancelled'])->change();
            $table->text('cancellation_reason')->nullable()->after('rescheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected'])->change();
            $table->dropColumn('cancellation_reason');
        });
    }
};
