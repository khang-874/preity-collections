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
        Schema::create('images', function (Blueprint $table) {
            $table->string('imageURL');

            $table->unsignedBigInteger('detail_id');
            $table->foreign('detail_id') -> references('id') -> on('details') -> onDelete('cascade') -> onUpdate('cascade');
            $table->primary(['imageURL', 'detail_id']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};