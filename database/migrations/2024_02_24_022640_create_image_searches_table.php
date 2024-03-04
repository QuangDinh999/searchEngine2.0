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
        Schema::create('image_searches', function (Blueprint $table) {
            $table->id();
            $table->string('imgName');
            $table->text('imgNameRelate1')->nullable();
            $table->text('imgNameRelate2')->nullable();
            $table->text('imgNameRelate3')->nullable();
            $table->text('imgNameRelate4')->nullable();
            $table->text('imgNameRelate5')->nullable();
            $table->text('imgNameRelate6')->nullable();
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->text('description3')->nullable();
            $table->text('description4')->nullable();
            $table->text('description5')->nullable();
            $table->text('description6')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_searches');
    }
};
