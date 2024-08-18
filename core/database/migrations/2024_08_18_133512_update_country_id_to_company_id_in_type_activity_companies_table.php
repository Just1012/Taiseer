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
        Schema::table('type_activity_companies', function (Blueprint $table) {
            // Drop the foreign key constraint for country_id
            $table->dropForeign(['country_id']);

            // Rename the column from country_id to company_id
            $table->renameColumn('country_id', 'company_id');

            // Add the new foreign key constraint referencing the companies table
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_activity_companies', function (Blueprint $table) {
            // Drop the foreign key constraint for company_id
            $table->dropForeign(['company_id']);

            // Rename the column back to country_id
            $table->renameColumn('company_id', 'country_id');

            // Add the original foreign key constraint referencing the countries table
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }
};
