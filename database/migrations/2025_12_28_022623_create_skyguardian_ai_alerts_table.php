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
        Schema::create('skyguardian_ai_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('analysis_id', 50)->unique();
            $table->string('trigger_level', 20);
            $table->text('ai_analysis_raw');
            $table->text('situation')->nullable();
            $table->string('threat_level', 50)->nullable();
            $table->text('primary_concern')->nullable();
            $table->text('secondary_concerns')->nullable();
            $table->string('likely_scenario', 100)->nullable();
            $table->text('recommendations')->nullable();
            $table->text('forecast')->nullable();
            $table->string('confidence', 50)->nullable();
            $table->dateTime('ai_timestamp');
            $table->decimal('ai_confidence_score', 3, 2)->default(0.5);
            $table->integer('ai_response_length')->default(0);
            $table->json('structured_data')->nullable();
            $table->timestamps();

            $table->index('analysis_id');
            $table->index('trigger_level');
            $table->index('ai_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_ai_alerts');
    }
};
