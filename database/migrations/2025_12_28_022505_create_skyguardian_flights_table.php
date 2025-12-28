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
        Schema::create('skyguardian_flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_id')->unique()->comment('Unique flight identifier');
            $table->foreignId('aircraft_id')->constrained('skyguardian_aircraft');
            $table->string('hex', 6)->comment('For quick lookup');
            $table->json('entry_data')->nullable()->comment('Entry event data');
            $table->json('exit_data')->nullable()->comment('Exit event data');
            $table->dateTime('entry_time');
            $table->dateTime('exit_time')->nullable();
            $table->integer('duration_seconds')->nullable()->comment('Flight duration in seconds');
            $table->float('max_altitude', 10, 2)->nullable();
            $table->float('min_altitude', 10, 2)->nullable();
            $table->float('avg_speed', 8, 2)->nullable();
            $table->json('tracking_points')->nullable()->comment('Flight path points');
            $table->integer('points_count')->default(0);
            $table->boolean('completed')->default(false);
            $table->string('status', 20)->default('active')->comment('active, completed, lost');
            $table->json('flight_metadata')->nullable();
            $table->timestamps();

            $table->index('hex');
            $table->index('entry_time');
            $table->index('exit_time');
            $table->index('status');
            $table->index(['aircraft_id', 'entry_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_flights');
    }
};
