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
        if (!Schema::hasTable('skyguardian_errors')) {
            Schema::create('skyguardian_errors', function (Blueprint $table) {
                $table->string('error_id', 50)->primary();
                $table->string('source', 100)->nullable();
                $table->string('error_type', 50)->nullable();
                $table->text('error_message')->nullable();
                $table->boolean('requires_retry')->default(false);
                $table->longText('error_context')->nullable();
                $table->string('workflow_version', 50)->nullable();
                $table->dateTime('logged_at')->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('skyguardian_aircraft')) {
            Schema::create('skyguardian_aircraft', function (Blueprint $table) {
                $table->id();
                $table->string('hex', 10)->unique();
                $table->string('registration', 20)->nullable();
                $table->string('callsign', 20)->nullable();
                $table->string('type', 20)->nullable();
                $table->string('aircraft_name', 100)->nullable();
                $table->string('category', 50)->nullable();
                $table->string('role', 50)->nullable();
                $table->string('country', 50)->nullable();
                $table->boolean('is_military')->default(false);
                $table->boolean('is_drone')->default(false);
                $table->boolean('is_nato')->default(false);
                $table->boolean('is_friendly')->default(false);
                $table->boolean('is_potential_threat')->default(false);
                $table->integer('threat_level')->default(1);
                $table->json('metadata')->nullable();
                $table->dateTime('last_seen')->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('skyguardian_positions')) {
            Schema::create('skyguardian_positions', function (Blueprint $table) {
                $table->id();
                $table->string('hex', 10)->index();
                $table->decimal('latitude', 10, 6);
                $table->decimal('longitude', 10, 6);
                $table->integer('altitude')->nullable();
                $table->float('speed')->nullable();
                $table->float('heading')->nullable();
                $table->float('vertical_rate')->nullable();
                $table->string('squawk', 10)->nullable();
                $table->string('source', 50)->nullable();
                $table->string('altitude_layer', 20)->nullable();
                $table->string('nearest_waypoint', 100)->nullable();
                $table->boolean('in_estonia')->default(false);
                $table->boolean('near_sensitive')->default(false);
                $table->boolean('near_military_base')->default(false);
                $table->boolean('near_border')->default(false);
                $table->integer('threat_level')->default(1);
                $table->json('position_metadata')->nullable();
                $table->dateTime('position_time')->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('skyguardian_analyses')) {
            Schema::create('skyguardian_analyses', function (Blueprint $table) {
                $table->string('analysis_id', 50)->primary();
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
                $table->float('anomaly_score')->default(0);
                $table->string('status', 50)->nullable();
                $table->integer('severity')->default(1);
                $table->float('confidence')->default(0);
                $table->boolean('is_night')->default(false);
                $table->boolean('is_weekend')->default(false);
                $table->float('trend_score')->default(0);
                $table->float('baseline')->default(0);
                $table->text('map_url')->nullable();
                $table->json('today_alerts')->nullable();
                $table->float('deduplication_rate')->default(0);
                $table->json('enhanced_stats')->nullable();
                $table->json('top_countries')->nullable();
                $table->json('scoring_breakdown')->nullable();
                $table->integer('composite_score')->default(0);
                $table->string('overall_risk', 50)->nullable();
                $table->boolean('persistent_alert')->default(false);

                $table->float('weather_multiplier')->default(1);
                $table->float('adjusted_anomaly_score')->default(0);
                $table->text('weather_notes')->nullable();
                $table->boolean('weather_significant')->default(false);
                $table->boolean('weather_critical')->default(false);
                $table->boolean('weather_api_available')->default(false);

                $table->json('estonia_context')->nullable();
                $table->json('external_data')->nullable();
                $table->json('final_assessment')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('skyguardian_ai_alerts')) {
            Schema::create('skyguardian_ai_alerts', function (Blueprint $table) {
                $table->string('analysis_id', 50)->primary();
                $table->string('trigger_level', 50)->nullable();
                $table->longText('ai_analysis_raw')->nullable();
                $table->json('translations')->nullable();
                $table->text('situation')->nullable();
                $table->string('threat_level', 50)->nullable();
                $table->text('primary_concern')->nullable();
                $table->text('secondary_concerns')->nullable();
                $table->text('likely_scenario')->nullable();
                $table->text('recommendations')->nullable();
                $table->text('forecast')->nullable();
                $table->string('confidence', 50)->nullable();
                $table->json('analysis_en')->nullable();
                $table->json('analysis_tr')->nullable();
                $table->json('analysis_et')->nullable();
                $table->json('multi_language_analysis')->nullable();
                $table->string('languages_available', 50)->default('en');
                $table->string('source_language', 10)->default('en');
                $table->dateTime('ai_timestamp')->nullable();
                $table->float('ai_confidence_score')->default(0);
                $table->integer('ai_response_length')->default(0);
                $table->json('structured_data')->nullable();
                $table->json('context')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('skyguardian_weather')) {
            Schema::create('skyguardian_weather', function (Blueprint $table) {
                $table->id();
                $table->string('location_id', 50)->index();
                $table->string('location_name', 100)->nullable();
                $table->decimal('longitude', 10, 6)->nullable();
                $table->decimal('latitude', 10, 6)->nullable();
                $table->string('weather_main', 50)->nullable();
                $table->string('weather_description', 100)->nullable();
                $table->string('weather_icon', 20)->nullable();
                $table->integer('weather_id')->nullable();
                $table->float('temperature')->nullable();
                $table->float('feels_like')->nullable();
                $table->float('temp_min')->nullable();
                $table->float('temp_max')->nullable();
                $table->integer('pressure')->nullable();
                $table->integer('humidity')->nullable();
                $table->integer('sea_level')->nullable();
                $table->integer('grnd_level')->nullable();
                $table->integer('visibility')->nullable();
                $table->float('wind_speed')->nullable();
                $table->integer('wind_degree')->nullable();
                $table->integer('clouds_all')->nullable();
                $table->integer('sunrise')->nullable();
                $table->integer('sunset')->nullable();
                $table->integer('data_timestamp')->nullable();
                $table->integer('timezone_offset')->nullable();
                $table->string('base', 50)->nullable();
                $table->integer('cod')->nullable();
                $table->string('country_code', 10)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_errors');
        Schema::dropIfExists('skyguardian_aircraft');
        Schema::dropIfExists('skyguardian_positions');
        Schema::dropIfExists('skyguardian_analyses');
        Schema::dropIfExists('skyguardian_ai_alerts');
        Schema::dropIfExists('skyguardian_weather');
    }
};
