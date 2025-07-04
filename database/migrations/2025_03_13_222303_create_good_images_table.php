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
        Schema::create('good_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('good_id')->nullable(false);
            $table->unsignedBigInteger('image_id')->nullable(false);
            $table->timestamp(column: 'created_at')->nullable(false)->useCurrent();
            $table->timestamp('updated_at')->nullable(false)->useCurrent()->useCurrentOnUpdate();
            $table->foreign(columns: 'good_id')->references('id')->on('goods')->cascadeOnDelete();
            $table->foreign(columns: 'image_id')->references('id')->on('images')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_images');
    }
};
