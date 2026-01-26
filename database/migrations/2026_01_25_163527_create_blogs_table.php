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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_tr');
            $table->string('title_ee');
            $table->string('slug_en');
            $table->string('slug_tr');
            $table->string('slug_ee');
            $table->string('excerpt_en');
            $table->string('excerpt_tr');
            $table->string('excerpt_ee');
            $table->string('image');
            $table->longText('body_en');
            $table->longText('body_tr');
            $table->longText('body_ee');
            $table->string('category_en');
            $table->string('category_tr');
            $table->string('category_ee');
            $table->dateTime('published_at');
            $table->tinyInteger('status');
            $table->string('resource');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
