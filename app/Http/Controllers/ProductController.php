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

    /**
     * Display products for admin.
     */
    public function index()
    {
        $products = Product::latest('prod_id')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'prod_nombre' => 'required|string|max:100',
            'prod_descripcion' => 'required|string',
            'prod_precio' => 'required|numeric|min:0',
            'prod_cantidad' => 'required|integer|min:0',
            'prod_categoria' => ['required', 'string', Rule::in($this->productCategories)],
            'prod_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('prod_imagen')) {
            $imageName = time().'.'.$request->prod_imagen->extension();
            $request->prod_imagen->move(public_path('img'), $imageName);
            $data['prod_imagen'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Producto agregado.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $data = $request->validate([
            'prod_nombre' => 'required|string|max:100',
            'prod_descripcion' => 'required|string',
            'prod_precio' => 'required|numeric|min:0',
            'prod_cantidad' => 'required|integer|min:0',
            'prod_categoria' => ['required', 'string', Rule::in($this->productCategories)],
            'prod_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('prod_imagen')) {
            $imageName = time().'.'.$request->prod_imagen->extension();
            $request->prod_imagen->move(public_path('img'), $imageName);
            $data['prod_imagen'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }
}
