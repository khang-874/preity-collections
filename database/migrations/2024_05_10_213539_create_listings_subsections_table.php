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
        Schema::create('listings_subsections', function (Blueprint $table) {
            $table->unsignedBigInteger('listing_id');
            $table->foreign('listing_id') -> references('id') -> on('listings') -> onDelete('cascade') -> onUpdate('cascade');
            
            $table->unsignedBigInteger('subsection_id');
            $table->foreign('subsection_id') -> references('id') -> on('subsections') -> onDelete('cascade') -> onUpdate('cascade');
            $table->primary(['listing_id', 'subsection_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings_subsections');
    }
};
