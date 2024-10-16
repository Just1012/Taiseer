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
        Schema::table('otp_attempts', function (Blueprint $table) {
            // Remove the foreign key and the user_id column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Add the phone_number field
            $table->string('phone_number', 15)->after('id'); // Add the phone number with a max length of 15
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('otp_attempts', function (Blueprint $table) {
            // Rollback the changes - Add the user_id field and foreign key again
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Drop the phone_number column
            $table->dropColumn('phone_number');
        });
    }
};
