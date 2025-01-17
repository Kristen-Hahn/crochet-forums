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
        Schema::create('commentlikesdislikes', function (Blueprint $table) {
            $table->id();
            $table->integer('commentID');
            $table->integer('userID');
            $table->boolean('liked')->nullable();
            $table->boolean('disliked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentlikesdislikes');
    }
};
