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
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id') -> references('id') -> on('orders') -> onUpdate('cascade') -> onDelete('cascade');

            $table -> string('payment_type');
            $table -> float('amount_paid');
            $table->timestamps();
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
