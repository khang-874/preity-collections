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
        //
        Schema::table('listings', function(Blueprint $table){
            $table -> boolean('is_clearance') -> default(false);
            $table -> float('sale_percentage') -> default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('listings', function(Blueprint $table){
            $table -> dropColumn('is_clearance');
            $table -> dropColumn('sale_percentage');
        });
    }
};
