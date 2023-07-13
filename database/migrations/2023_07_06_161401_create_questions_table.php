<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('round');
            $table->integer('clue_value')->nullable();
            $table->integer('daily_double_value')->nullable();
            $table->string('category');
            $table->text('comments')->nullable();
            $table->text('answer');
            $table->text('question');
            $table->date('air_date');
            $table->text('notes')->nullable();
            $table->uuid('episode_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
