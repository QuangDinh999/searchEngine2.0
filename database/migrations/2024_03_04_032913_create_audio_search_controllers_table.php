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
        Schema::create('audio_search_controllers', function (Blueprint $table) {
            $table->id();
            $table->string('audioName', 30);
            $table->string('Song_name',45)->nullable();
            $table->text('songDescription');
            $table->text('video_relate')->nullable();
            $table->text('videoDescription');
            $table->string('people_1', 45)->nullable();
            $table->text('people_1_img')->nullable();
            $table->text('descriptionPeople_1')->nullable();
            $table->string('people_2', 45)->nullable();
            $table->text('people_2_img')->nullable();
            $table->text('descriptionPeople_2')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_search_controllers');
    }
};
