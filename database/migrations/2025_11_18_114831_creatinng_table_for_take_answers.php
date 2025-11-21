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
        Schema::create('take_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id')->on('users')->references('id')->cascadeOnDelete();
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->on('questions')->references('id')->cascadeOnDelete();
            $table->unsignedBigInteger('answer_id');
            $table->foreign('answer_id')->on('answers')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_answers');
    }
};
