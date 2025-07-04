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
        Schema::create('login_tokens', function (Blueprint $table) {
            $table->id();
            $table->TEXT(column: 'token');
            $table->unsignedBigInteger('user_id')->unique()->nullable(false)->index();
            $table->timestamp('created_at')->nullable(false)->useCurrent();
            $table->timestamp('expires_at')->nullable(false);
            $table->foreign(columns: 'user_id')->references('id')->on('users')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_tokens');
    }
};
