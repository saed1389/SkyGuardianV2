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
        Schema::create('skyguardian_analyses', function (Blueprint $table) {
            $table->id();
            $table->string('analysis_id', 50)->unique()->comment('Unique analysis identifier');
            $table->dateTime('analysis_time')->index();
            $table->integer('total_aircraft')->default(0);
            $table->integer('military_aircraft')->default(0);
            $table->integer('drones')->default(0);
            $table->integer('civil_aircraft')->default(0);
            $table->integer('near_sensitive')->default(0);
            $table->integer('high_speed')->default(0);
            $table->integer('low_altitude')->default(0);
            $table->integer('high_threat_aircraft')->default(0);
            $table->integer('potential_threats')->default(0);
            $table->integer('nato_aircraft')->default(0);
            $table->integer('anomaly_score')->default(0);
            $table->string('status', 50);
            $table->integer('severity')->default(1);
            $table->decimal('confidence', 3, 2)->default(0.5);
            $table->boolean('is_night')->default(false);
            $table->boolean('is_weekend')->default(false);
            $table->integer('trend_score')->default(0);
            $table->integer('baseline')->default(0);
            $table->text('map_url')->nullable();
            $table->json('today_alerts')->nullable();
            $table->decimal('deduplication_rate', 5, 2)->default(0);
            $table->json('enhanced_stats')->nullable();
            $table->json('top_countries')->nullable();
            $table->json('scoring_breakdown')->nullable();
            $table->integer('composite_score')->default(0);
            $table->string('overall_risk', 20)->default('LOW');
            $table->boolean('persistent_alert')->default(false);
            $table->decimal('weather_multiplier', 4, 2)->default(1.0);
            $table->integer('adjusted_anomaly_score')->default(0);
            $table->text('weather_notes')->nullable();
            $table->boolean('weather_significant')->default(false);
            $table->boolean('weather_critical')->default(false);
            $table->boolean('weather_api_available')->default(false);
            $table->json('estonia_context')->nullable();
            $table->json('external_data')->nullable();
            $table->json('final_assessment')->nullable();
            $table->timestamps();

            $table->index('severity');
            $table->index('anomaly_score');
            $table->index('overall_risk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_analyses');
    }
};
