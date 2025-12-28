<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skyguardian_positions', function (Blueprint $table) {
            $table->id();
            $table->string('hex', 6)->index();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('altitude', 8, 2)->nullable();
            $table->decimal('speed', 6, 2)->nullable();
            $table->decimal('heading', 5, 2)->nullable();
            $table->decimal('vertical_rate', 6, 2)->nullable();
            $table->string('squawk', 10)->nullable();
            $table->string('source', 50);
            $table->string('altitude_layer', 20)->default('unknown');
            $table->string('nearest_waypoint', 100)->nullable();
            $table->boolean('in_estonia')->default(false);
            $table->boolean('near_sensitive')->default(false);
            $table->boolean('near_military_base')->default(false);
            $table->boolean('near_border')->default(false);
            $table->integer('threat_level')->default(1);
            $table->json('position_metadata')->nullable();
            $table->dateTime('position_time');
            $table->timestamps();

            $table->index('position_time');
            $table->index(['latitude', 'longitude']);
            $table->index('altitude_layer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skyguardian_positions');
    }
};
