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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable()->comment('Owner Name');
            $table->string('name_en')->nullable()->comment('Owner Name');
            $table->string('email')->unique();
            $table->string('code')->nullable()->comment('Country Key Code');
            $table->string('phone')->nullable();
            $table->string('BL')->nullable()->comment('Commercial License Number');
            $table->string('BL_image')->nullable()->comment('Commercial License Image');
            $table->string('id_front_image')->nullable();
            $table->text('about_ar')->nullable();
            $table->text('about_en')->nullable();
            $table->unsignedBigInteger('company_status_id');
            $table->foreign('company_status_id')->references('id')->on('company_statuses')->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
