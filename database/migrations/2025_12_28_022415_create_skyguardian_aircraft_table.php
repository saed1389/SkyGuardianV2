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
        Schema::create('skyguardian_aircraft', function (Blueprint $table) {
            $table->id();
            $table->string('hex', 6)->unique()->comment('ICAO hex code');
            $table->string('registration', 10)->nullable()->comment('Aircraft registration');
            $table->string('callsign', 20)->nullable()->comment('Flight callsign');
            $table->string('type', 10)->nullable()->comment('Aircraft type code (B738, A320, etc)');
            $table->string('aircraft_name')->nullable()->comment('Full aircraft name');
            $table->string('category', 50)->nullable()->comment('aircraft_category from enrichment');
            $table->string('role', 100)->nullable()->comment('aircraft_role from enrichment');
            $table->string('country', 100)->nullable()->comment('country_of_origin');
            $table->boolean('is_military')->default(false);
            $table->boolean('is_drone')->default(false);
            $table->boolean('is_nato')->default(false);
            $table->boolean('is_friendly')->default(false);
            $table->boolean('is_potential_threat')->default(false);
            $table->integer('threat_level')->default(1)->comment('1-5 scale');
            $table->json('metadata')->nullable()->comment('Additional aircraft info');
            $table->dateTime('last_seen')->nullable();
            $table->timestamps();

            $table->index('hex');
            $table->index('country');
            $table->index('is_military');
            $table->index('threat_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_aircraft');
    }
};
