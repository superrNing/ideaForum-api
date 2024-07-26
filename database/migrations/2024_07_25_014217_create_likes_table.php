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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->enum('like_type', ['like', 'dislike']);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('idea_id')->unsigned();
            // Unique constraint to ensure a user can only like once per idea
            $table->unique(['idea_id', 'user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idea_id')->references('id')->on('ideas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
