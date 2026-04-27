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
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->enum('Soli_estado', [
                'Pendiente', 
                'Asignada', 
                'En Revisión', 
                'En Entrevista', 
                'Aprobada', 
                'Aceptada',
                'Rechazada', 
                'No Apta', 
                'No Aptas', 
                'Aptas',
                'Proceso Adopcion', 
                'En Proceso'
            ])->default('Pendiente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->enum('Soli_estado', [
                'Pendiente', 
                'Asignada', 
                'En Revisión', 
                'Aptas', 
                'No Aptas', 
                'Aceptada', 
                'Rechazada'
            ])->default('Pendiente')->change();
        });
    }
};
