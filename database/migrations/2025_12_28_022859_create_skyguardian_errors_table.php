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
        Schema::create('skyguardian_errors', function (Blueprint $table) {
            $table->id();
            $table->string('error_id', 100)->unique();
            $table->string('source', 100);
            $table->string('error_type', 50);
            $table->text('error_message');
            $table->boolean('requires_retry')->default(false);
            $table->text('error_context')->nullable();
            $table->string('workflow_version', 50);
            $table->dateTime('logged_at');
            $table->timestamps();

            $table->index('error_id');
            $table->index('source');
            $table->index('logged_at');
            $table->index('requires_retry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyguardian_errors');
    }
};
