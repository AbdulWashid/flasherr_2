<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_request_id')->constrained('sale_requests')->onDelete('cascade');
            $table->decimal('quantity', 18, 8);
            $table->enum('status',['pending','sold','cancelled'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->boolean('display_status')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
