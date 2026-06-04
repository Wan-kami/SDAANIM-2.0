<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;

// Get all products
$products = Product::all();

echo "\n=== VERIFICANDO PRODUCTOS Y COLORES/TALLAS ===\n";
echo "Total de productos: " . $products->count() . "\n\n";

foreach ($products as $product) {
    echo "Producto: {$product->prod_nombre} (ID: {$product->prod_id})\n";
    echo "  - Categoría: {$product->prod_categoria}\n";
    echo "  - Colores: " . $product->colors()->count() . "\n";
    echo "  - Tallas: " . $product->sizes()->count() . "\n";
    
    // Si es ropa o accesorios, agregar colores y tallas
    if (in_array($product->prod_categoria, ['Ropa', 'Accesorios'])) {
        // Agregar colores si no tiene
        if ($product->colors()->count() == 0) {
            $colors_data = [
                ['color_nombre' => 'Negro', 'color_hex' => '#000000', 'disponible' => 1],
                ['color_nombre' => 'Blanco', 'color_hex' => '#FFFFFF', 'disponible' => 1],
                ['color_nombre' => 'Rojo', 'color_hex' => '#FF0000', 'disponible' => 1],
                ['color_nombre' => 'Azul', 'color_hex' => '#0000FF', 'disponible' => 1],
            ];
            
            foreach ($colors_data as $color) {
                ProductColor::create([
                    'prod_id' => $product->prod_id,
                    ...$color
                ]);
            }
            echo "  ✓ Colores agregados\n";
        }
        
        // Agregar tallas si no tiene
        if ($product->sizes()->count() == 0) {
            $sizes_data = [
                ['talla' => 'XS', 'disponible' => 1, 'cantidad' => 5],
                ['talla' => 'S', 'disponible' => 1, 'cantidad' => 10],
                ['talla' => 'M', 'disponible' => 1, 'cantidad' => 15],
                ['talla' => 'L', 'disponible' => 1, 'cantidad' => 10],
                ['talla' => 'XL', 'disponible' => 1, 'cantidad' => 5],
            ];
            
            foreach ($sizes_data as $size) {
                ProductSize::create([
                    'prod_id' => $product->prod_id,
                    ...$size
                ]);
            }
            echo "  ✓ Tallas agregadas\n";
        }
    }
    echo "\n";
}

echo "\n=== VERIFICACIÓN COMPLETADA ===\n";
