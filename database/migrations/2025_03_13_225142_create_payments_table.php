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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->nullable(false);
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->unsignedBigInteger('payment_method_id')->nullable(false);
            $table->date('payment_date')->nullable(false);
            $table->decimal('price')->nullable(false);
            $table->timestamp(column: 'created_at')->nullable(false)->useCurrent();
            $table->timestamp('updated_at')->nullable(false)->useCurrent()->useCurrentOnUpdate();
            $table->foreign(columns: 'cart_id')->references('id')->on('carts')->cascadeOnDelete();
            $table->foreign(columns: 'order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign(columns: 'payment_method_id')->references('id')->on('payment_methods')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
