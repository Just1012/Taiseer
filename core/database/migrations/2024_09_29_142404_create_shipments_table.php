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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
            $table->enum('shipment_type', ['specific', 'general']);
            $table->string('content_description');
            $table->date('expected_delivery_date');
            $table->unsignedBigInteger('from_address_id');
            $table->foreign('from_address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');
            $table->unsignedBigInteger('to_address_id');
            $table->foreign('to_address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->enum('status', [
                'new',
                'accepted',
                'in_transit',
                'delivered',
                'rejected',
                'closed'
            ])->default('new');
            $table->enum('payment_method', ['cash', 'online']);
            $table->string('tracking_number')->unique();
            $table->tinyInteger('rating')
                ->unsigned()
                ->nullable()
                ->comment('Customer rating (1-5)');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
