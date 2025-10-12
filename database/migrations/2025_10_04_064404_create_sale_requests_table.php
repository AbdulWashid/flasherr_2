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
        Schema::create('sale_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('whatsapp_number')->nullable();
            $table->string('wallet_address');
            $table->decimal('quantity', 18, 8);
            $table->json('documents_paths')->nullable();
            $table->string('status')->default('pending');
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_read')->nullable()->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_requests');
    }
};
