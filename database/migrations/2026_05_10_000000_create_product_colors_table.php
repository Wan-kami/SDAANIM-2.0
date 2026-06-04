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
        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prod_id');
            $table->string('color_nombre', 50);
            $table->string('color_hex', 7)->nullable(); // e.g., #FF5733
            $table->boolean('disponible')->default(true);
            $table->timestamps();
            
            $table->foreign('prod_id')->references('prod_id')->on('products')->onDelete('cascade');
            $table->index('prod_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
