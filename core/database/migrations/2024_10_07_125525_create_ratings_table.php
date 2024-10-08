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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            // Foreign key for user_id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Foreign key for company_id
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
                
            // Foreign key for shipment_id
            $table->unsignedBigInteger('shipment_id');
            $table->foreign('shipment_id')
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade');

            // Rating field (use validation for the range of 1-5 in your application logic)
            $table->tinyInteger('rate')->unsigned()->comment('Rating between 1 and 5');

            // Optional comment
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
