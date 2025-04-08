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
        // MEDICINE ORDERS
        Schema::create('medicine_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('medical_stores')->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed']);
            $table->decimal('total_amount', 10, 2);
            $table->string('uploaded_prescription_url')->nullable();
            $table->string('bill_url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_orders');
    }
};
