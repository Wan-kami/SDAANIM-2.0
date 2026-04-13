<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Valid categories for products.
     *
     * Keep this in sync with the database enum values.
     */
    protected array $productCategories = ['Alimentos', 'Juguetes', 'Camas', 'Accesorios', 'Ropa'];

    /**
     * Display products for the public.
     */
    public function publicIndex()
    {
        $products = Product::latest('prod_id')->get();
        return view('products.public_index', compact('products'));
    }
}
