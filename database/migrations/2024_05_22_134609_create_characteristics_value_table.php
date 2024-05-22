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
        Schema::create('characteristics_value', function (Blueprint $table) {
            $table->unsignedBigInteger('detail_id');
            $table->foreign('detail_id') -> references('id') -> on('details') -> onDelete('cascade') -> onUpdate('cascade');
            
            $table -> unsignedBigInteger('characteristic_id');
            $table -> foreign('characteristic_id') -> references('id') -> on('characteristics') -> onDelete('cascade') -> onUpdate('cascade');

            $table->string('value');

            $table->primary('detail_id', 'characteristic_id','value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characteristics_value');
    }
};
