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
        Schema::create('shipment_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->foreign('shipment_id')
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade');
            $table->enum('status', [
                'new',
                'accepted',
                'in_transit',
                'delivered',
                'rejected',
                'closed'
            ]);
            $table->timestamp('changed_at')
                ->useCurrent()
                ->comment('Timestamp of status change');

            $table->unsignedBigInteger('changed_by')->nullable();
            $table->foreign('changed_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_status_histories');
    }
};
