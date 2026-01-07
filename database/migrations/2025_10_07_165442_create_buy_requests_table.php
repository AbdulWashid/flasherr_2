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
        Schema::create('buy_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade'); // Assumes relation is with 'sales' table
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('payment_proof');
            $table->string('transaction_id');
            $table->string('network_type'); // e.g., trc20, bep20
            $table->string('wallet_address');
            $table->decimal('quantity', 18, 8);
            $table->string('status')->default('pending'); // You might want an enum here
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_requests');
    }
};
