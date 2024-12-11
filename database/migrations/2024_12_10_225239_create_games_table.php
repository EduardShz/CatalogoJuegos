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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('published_year', 4);
            $table->float('rating');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('platform_id');
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')
            ->on('creators');
            $table->foreign('platform_id')->references('id')
            ->on('platforms');
            $table->foreign('genre_id')->references('id')
            ->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
