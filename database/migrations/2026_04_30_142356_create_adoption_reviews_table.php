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
        if (!Schema::hasTable('adoption_reviews')) {
            Schema::create('adoption_reviews', function (Blueprint $table) {
                $table->id('rev_id');
                $table->unsignedBigInteger('soli_id');
                $table->unsignedBigInteger('Usu_documento');
                $table->integer('rev_estrellas');
                $table->text('rev_comentario')->nullable();
                $table->timestamps();

                $table->foreign('soli_id')->references('Soli_id')->on('adoption_requests')->onDelete('cascade');
                $table->foreign('Usu_documento')->references('Usu_documento')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_reviews');
    }
};
