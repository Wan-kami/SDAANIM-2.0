@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.products') }}" class="fancy-btn"><span>← Volver</span></a>

    <section class="admin-form">
        <h2>{{ isset($product) ? 'Editar Producto' : 'Agregar Producto' }}</h2>
        <form action="{{ isset($product) ? route('admin.products.update', $product->prod_id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
            @method('PUT')
            @endif

            <label for="prod_nombre">Nombre del producto:</label>
            <input type="text" id="prod_nombre" name="prod_nombre" value="{{ isset($product) ? $product->prod_nombre : old('prod_nombre') }}" required>

            <label for="prod_descripcion">Descripción:</label>
            <textarea id="prod_descripcion" name="prod_descripcion" rows="3">{{ isset($product) ? $product->prod_descripcion : old('prod_descripcion') }}</textarea>

            <label for="prod_categoria">Categoria:</label>
            <select id="prod_categoria" name="prod_categoria" required>
                <option value="">Seleccionar</option>
                <option value="Alimentos" {{ (isset($product) && $product->prod_categoria == 'Alimentos') ? 'selected' : '' }}>Alimentos</option>
                <option value="Juguetes" {{ (isset($product) && $product->prod_categoria == 'Juguetes') ? 'selected' : '' }}>Juguetes</option>
                <option value="Camas" {{ (isset($product) && $product->prod_categoria == 'Camas') ? 'selected' : '' }}>Camas</option>
                <option value="Accesorios" {{ (isset($product) && $product->prod_categoria == 'Accesorios') ? 'selected' : '' }}>Accesorios</option>
                <option value="Ropa" {{ (isset($product) && $product->prod_categoria == 'Ropa') ? 'selected' : '' }}>Ropa</option>
            </select>

            <label for="prod_precio">Precio:</label>
            <input type="number" step="0.01" id="prod_precio" name="prod_precio" value="{{ isset($product) ? $product->prod_precio : old('prod_precio') }}" required>

            <label for="prod_cantidad">Cantidad:</label>
            <input type="number" id="prod_cantidad" name="prod_cantidad" value="{{ isset($product) ? $product->prod_cantidad : old('prod_cantidad') }}" required>

            <label for="prod_imagen">Imagen:</label>
            <input type="file" id="prod_imagen" name="prod_imagen" accept="image/*">

            @if(isset($product) && $product->prod_imagen)
            <p>Imagen actual:</p>
            <img src="{{ asset('storage/products/' . $product->prod_imagen) }}" width="120" style="border-radius: 8px;">
            @endif

            <button type="submit">{{ isset($product) ? 'Actualizar' : 'Guardar' }}</button>
        </form>
    </section>
</main>
@endsection
