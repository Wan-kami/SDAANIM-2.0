<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quienes_somos', function (Blueprint $table) {
            $table->id();
            $table->text('mision')->nullable();
            $table->text('vision')->nullable();
            $table->longText('valores')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quienes_somos');
    }
};
