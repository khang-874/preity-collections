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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('init_price');
            $table->float('weight');
            $table->text('images');
            $table -> text('event') -> nullable();
            $table -> unsignedBigInteger('subsection_id');
            $table -> foreign('subsection_id') -> references('id') -> on('subsections');

            $table -> unsignedBigInteger('vendor_id');
            $table -> foreign('vendor_id') -> references('id') -> on('vendors'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
