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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 50)->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('transaction_type', ['debit', 'credit']);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('payment_method', ['online', 'cash']);
            $table->unsignedBigInteger('shipment_id');
            $table->foreign('shipment_id')
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
