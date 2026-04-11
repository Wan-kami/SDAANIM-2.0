<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('Cita_id');
            $table->unsignedBigInteger('Anim_id');
            $table->unsignedBigInteger('Usu_documento');
            $table->dateTime('Cita_fecha');
            $table->string('Cita_motivo', 255)->nullable();
            $table->string('Cita_estado', 50)->default('Pendiente');
            $table->timestamps();

            $table->foreign('Anim_id')->references('Anim_id')->on('animals')->onDelete('cascade');
            $table->foreign('Usu_documento')->references('Usu_documento')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
