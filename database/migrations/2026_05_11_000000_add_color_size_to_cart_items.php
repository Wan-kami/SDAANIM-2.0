<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Drop the old unique constraint
            $table->dropUnique(['Usu_documento', 'prod_id']);
            
            // Add color and size columns
            $table->unsignedBigInteger('color_id')->nullable()->after('prod_id');
            $table->unsignedBigInteger('size_id')->nullable()->after('color_id');
            
            // Create new unique constraint with color and size
            $table->unique(['Usu_documento', 'prod_id', 'color_id', 'size_id']);
            
            // Add foreign keys
            $table->foreign('color_id')->references('id')->on('product_colors')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('product_sizes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropForeign(['size_id']);
            $table->dropUnique(['Usu_documento', 'prod_id', 'color_id', 'size_id']);
            $table->dropColumn(['color_id', 'size_id']);
            $table->unique(['Usu_documento', 'prod_id']);
        });
    }
};
