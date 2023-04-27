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
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            // titles, authors, and publication dates.
            $table->string('title')->length(255);
            $table->string('authors')->length(255);
            $table->date('pubdate');
            $table->string('is_headline');
            $table->string('foto')->length(255)->nullable();
            $table->string('content')->length(255)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
