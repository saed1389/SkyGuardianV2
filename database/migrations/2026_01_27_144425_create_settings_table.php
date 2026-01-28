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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->longText('privacy_en')->nullable();
            $table->longText('privacy_tr')->nullable();
            $table->longText('privacy_ee')->nullable();
            $table->longText('term_en')->nullable();
            $table->longText('term_tr')->nullable();
            $table->longText('term_ee')->nullable();
            $table->longText('license_en')->nullable();
            $table->longText('license_tr')->nullable();
            $table->longText('license_ee')->nullable();
            $table->longText('compliance_en')->nullable();
            $table->longText('compliance_tr')->nullable();
            $table->longText('compliance_ee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
