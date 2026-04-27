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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('Noti_titulo', 150)->nullable()->after('Usu_documento');
            $table->string('Noti_tipo', 50)->nullable()->after('Noti_mensaje');
            $table->boolean('Noti_leido')->default(false)->after('Noti_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['Noti_titulo', 'Noti_tipo', 'Noti_leido']);
        });
    }
};
