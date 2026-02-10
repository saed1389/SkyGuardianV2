<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('skyguardian_sensors', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique();
            $table->string('name');
            $table->string('type')->default('GENERIC');
            $table->string('ip_address')->nullable();
            $table->float('temperature')->nullable();
            $table->float('cpu_load')->nullable();
            $table->integer('uptime_seconds')->default(0);
            $table->string('status')->default('OFFLINE');
            $table->timestamp('last_seen')->nullable();
            $table->string('api_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_sensors');
    }
};
