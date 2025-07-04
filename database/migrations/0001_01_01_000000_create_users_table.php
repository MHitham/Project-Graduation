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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->primary(true);
            $table->string('first_name', 20)->nullable(false);
            $table->string('last_name', 20)->nullable(false);
            $table->string('email',100)->unique()->nullable(false);
            $table->string('username', 100)->unique()->nullable(false);
            $table->tinyInteger('is_two_factor_enabled')->default(0);
            $table->tinyInteger('is_email_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable(false);
            $table->rememberToken();
            $table->timestamp('created_at')->nullable(false)->useCurrent();
            $table->timestamp('updated_at')->nullable(false)->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
