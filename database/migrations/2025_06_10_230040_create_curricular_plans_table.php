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
        Schema::create('curricular_plans', function (Blueprint $table) {
             $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('age_range')->nullable();
            $table->string('grade_level')->nullable();
            $table->string('pedagogical_style')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curricular_plans');
    }
};
