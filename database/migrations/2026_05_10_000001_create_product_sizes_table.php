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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prod_id');
            $table->string('talla', 20); // XS, S, M, L, XL, XXL, etc.
            $table->boolean('disponible')->default(true);
            $table->integer('cantidad')->default(0);
            $table->timestamps();
            
            $table->foreign('prod_id')->references('prod_id')->on('products')->onDelete('cascade');
            $table->index('prod_id');
            $table->unique(['prod_id', 'talla']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
