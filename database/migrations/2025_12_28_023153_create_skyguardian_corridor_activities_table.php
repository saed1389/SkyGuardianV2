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
        Schema::create('skyguardian_corridor_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corridor_id')->constrained('skyguardian_corridors');
            $table->timestamp('activity_time')->useCurrent();
            $table->integer('aircraft_count');
            $table->integer('military_count')->default(0);
            $table->integer('drone_count')->default(0);
            $table->float('avg_speed', 8, 2)->nullable();
            $table->float('avg_altitude', 10, 2)->nullable();
            $table->json('aircraft_types')->nullable();
            $table->json('countries')->nullable();
            $table->float('busyness_score', 5, 2)->comment('0-100 scale');
            $table->timestamps();

            $table->index('activity_time');
            $table->index(['corridor_id', 'activity_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_corridor_activities');
    }
};
