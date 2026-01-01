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
        Schema::create('skyguardian_weather', function (Blueprint $table) {
            $table->id();

            // Location coordinates
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);

            // Weather information
            $table->string('weather_main');
            $table->string('weather_description');
            $table->string('weather_icon');
            $table->integer('weather_id');

            // Temperature and atmospheric data
            $table->decimal('temperature', 5, 2);
            $table->decimal('feels_like', 5, 2);
            $table->decimal('temp_min', 5, 2);
            $table->decimal('temp_max', 5, 2);
            $table->integer('pressure');
            $table->integer('humidity');
            $table->integer('sea_level')->nullable();
            $table->integer('grnd_level')->nullable();

            // Visibility
            $table->integer('visibility')->nullable();

            // Wind data
            $table->decimal('wind_speed', 5, 2);
            $table->integer('wind_degree');

            // Clouds
            $table->integer('clouds_all');

            // System data
            $table->string('country_code', 2);
            $table->string('location_name');
            $table->integer('location_id');
            $table->integer('sunrise');
            $table->integer('sunset');

            // Timestamps
            $table->integer('data_timestamp'); // dt from API
            $table->integer('timezone_offset'); // timezone from API
            $table->string('base')->nullable(); // base from API

            // Status
            $table->integer('cod'); // HTTP response code

            // Laravel timestamps
            $table->timestamps();

            // Indexes for better query performance
            $table->index('location_id');
            $table->index('data_timestamp');
            $table->index('country_code');
            $table->index('weather_main');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_weather');
    }
};
