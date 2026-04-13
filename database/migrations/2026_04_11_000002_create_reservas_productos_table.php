<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas_productos', function (Blueprint $table) {
            $table->id('re_id');
            $table->string('re_sid', 255)->nullable();
            $table->unsignedBigInteger('prod_id');
            $table->string('usuario_id', 255);
            $table->timestamp('re_fecha')->nullable();
            $table->string('re_estado', 50)->default('Pendiente');
            $table->timestamps();

            $table->foreign('prod_id')->references('prod_id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas_productos');
    }
};
