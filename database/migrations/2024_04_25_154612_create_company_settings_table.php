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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_logo');
            $table->string('company_name');
            $table->text('company_info');
            $table->text('service_info');
            $table->text('company_info_mm');
            $table->text('service_info_mm');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->string('facebook_page');
            $table->time('open_hour');
            $table->time('close_hour');
            $table->string('close_day');
            $table->text('gallery1_photos')->nullable();
            $table->text('gallery2_photos')->nullable();
            $table->text('location_point');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
