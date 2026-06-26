<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            // Adding 'En Proceso' to the enum
            DB::statement("ALTER TABLE adoption_requests MODIFY COLUMN Soli_estado ENUM('Pendiente', 'Asignada', 'En Entrevista', 'Aprobada', 'No Apta', 'Proceso Adopcion', 'Rechazada', 'En Proceso') DEFAULT 'Pendiente'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE adoption_requests MODIFY COLUMN Soli_estado ENUM('Pendiente', 'Asignada', 'En Entrevista', 'Aprobada', 'No Apta', 'Proceso Adopcion', 'Rechazada') DEFAULT 'Pendiente'");
        }
    }
};
