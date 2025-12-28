<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skyguardian_zones', function (Blueprint $table) {
            $table->id();

            $table->string('zone_id')->unique();
            $table->string('name');
            $table->string('type', 50)->comment('airport, military_base, border, sensitive, etc');
            $table->string('country', 2)->default('EE');

            // Keep readable columns
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);

            $table->decimal('radius_km', 8, 2)->default(5);
            $table->string('description')->nullable();
            $table->integer('threat_weight')->default(1);
            $table->boolean('is_active')->default(true);
            $table->json('zone_metadata')->nullable();
            $table->timestamps();

            // Normal indexes
            $table->index('type');
            $table->index('country');
        });

        // 👇 MySQL-correct spatial column
        DB::statement("
            ALTER TABLE skyguardian_zones
            ADD location POINT NOT NULL
        ");

        // 👇 Single-column spatial index (REQUIRED by MySQL)
        DB::statement("
            ALTER TABLE skyguardian_zones
            ADD SPATIAL INDEX skyguardian_zones_location_spatialindex (location)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('skyguardian_zones');
    }
};
