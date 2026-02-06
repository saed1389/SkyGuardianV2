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
        Schema::create('skyguardian_nato_reports', function (Blueprint $table) {
            $table->string('report_id', 50)->primary();
            $table->dateTime('timestamp')->index();
            $table->string('report_type', 20)->default('SALUTE');
            $table->string('threat_level', 20)->nullable();
            $table->string('salute_size', 100)->nullable();
            $table->text('salute_activity')->nullable();
            $table->text('salute_location')->nullable();
            $table->text('salute_unit')->nullable();
            $table->string('salute_time', 50)->nullable();
            $table->text('salute_equipment')->nullable();
            $table->text('full_report_text')->nullable();
            $table->boolean('is_transmitted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_nato_reports');
    }
};
