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
        Schema::create('orders_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('listing_id');
            $table->foreign('listing_id') -> references('id') -> on('listings') -> onDelete('cascade') -> onUpdate('cascade');
            
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id') -> references('id') -> on('orders');

            $table -> unsignedBigInteger('detail_id');
            $table->foreign('detail_id') -> references('id') -> on('details');
            
            $table -> integer('quantity');

            $table->primary(['listing_id', 'order_id', 'detail_id']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_listings');
    }
};
