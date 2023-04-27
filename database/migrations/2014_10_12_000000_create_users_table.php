<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'Super Admin', 
            'email' => 'admin@superuser.id',
            'password' => '$2y$10$47zdAbaROe8JwSStCkIlfO15UXwEanTy8ZXsWQMdIbU0RcJ7yzU4y', 
            'remember_token' => '$2y$10$47zdAbaROe8JwSStCkIlfO15UXwEanTy8ZXsWQMdIbU0RcJ7yzU4y'
        ]
    );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
