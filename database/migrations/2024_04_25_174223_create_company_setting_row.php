<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Define the data you want to add to the company_settings table
        $data = [
            'company_logo' => '---',
            'company_name' => '---',
            'company_info' => '---',
            'service_info' => '---',
            'company_info_mm' => '---',
            'service_info_mm' => '---',
            'phone_number' => '000000000',
            'email' => '--@gmail.com',
            'address' => '---',
            'facebook_page' => '---',
            'open_hour' => '0:00',
            'close_hour' => '0:00',
            'close_day' => '---',
            'gallery1_photos' => 'img.jpg',
            'gallery2_photos' => 'img.jpg',
            'location_point' => '---',
            'created_by' => 3, // User ID of the creator
            'updated_by' => 3, // User ID of the updater
        ];

        // Insert the data into the company_settings table
        DB::table('company_settings')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
