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
        Schema::create('skyguardian_corridors', function (Blueprint $table) {
            $table->id();
            $table->string('corridor_id')->unique();
            $table->string('name')->comment('North-South, East-West, etc');
            $table->string('entry_point', 100)->nullable();
            $table->string('exit_point', 100)->nullable();
            $table->json('typical_altitudes')->nullable();
            $table->integer('avg_daily_traffic')->default(0);
            $table->float('peak_hour_traffic', 8, 2)->nullable();
            $table->string('primary_aircraft_type', 100)->nullable();
            $table->boolean('is_military_corridor')->default(false);
            $table->boolean('is_international_route')->default(false);
            $table->json('corridor_bounds')->nullable()->comment('GeoJSON polygon');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('is_military_corridor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_corridors');
    }
};
