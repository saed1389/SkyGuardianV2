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
        Schema::create('skyguardian_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('stat_date')->unique();
            $table->integer('total_aircraft_daily');
            $table->integer('total_flights_daily');
            $table->integer('military_flights_daily');
            $table->integer('drone_flights_daily');
            $table->integer('unique_aircraft_daily');
            $table->integer('border_crossings_daily');
            $table->integer('airspace_violations_daily');
            $table->integer('high_risk_alerts_daily');
            $table->integer('critical_alerts_daily');
            $table->float('avg_anomaly_score', 5, 2);
            $table->float('peak_anomaly_score', 5, 2);
            $table->json('busiest_hours')->nullable();
            $table->json('top_countries_daily')->nullable();
            $table->json('most_active_zones')->nullable();
            $table->float('api_success_rate', 5, 2)->default(100);
            $table->timestamps();

            $table->index('stat_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_statistics');
    }
};
