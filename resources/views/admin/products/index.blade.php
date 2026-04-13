@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>
    <h2>Gestión productos para mascotas</h2>
    <p style="text-align:center;">Administra los productos o accesorios para las mascotas</p>

    <div class="adopta-grid">
        @forelse($products as $product)
        <div class="adopta-card">
            @if($product->prod_imagen)
            <img src="{{ asset('img/' . $product->prod_imagen) }}" alt="{{ $product->prod_nombre }}">
            @else
            <img src="{{ asset('img/default.png') }}" alt="Sin imagen">
            @endif
            <h3>{{ $product->prod_nombre }}</h3>
            <p>Categoria: {{ $product->prod_categoria }}</p>
            <p>Precio: ${{ number_format($product->prod_precio, 2) }}</p>
            <p>Cantidad: {{ $product->prod_cantidad }}</p>
            <div style="display: flex; gap: 5px; justify-content: center;">
                <button onclick="window.location.href='{{ route('admin.products.edit', $product->prod_id) }}'">Editar</button>
                <form action="{{ route('admin.products.destroy', $product->prod_id) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #dc3545;">Eliminar</button>
                </form>
            </div>
        </div>
        @empty
        <p style="text-align:center; grid-column: 1/-1;">No hay productos registrados aún 🐾</p>
        @endforelse

        <div class="adopta-card add-card" onclick="window.location.href='{{ route('admin.products.create') }}'">
            <img src="{{ asset('img/agregar.png') }}" alt="Agregar nuevo">
            <h3>Agregar nuevo producto</h3>
        </div>
    </div>
</main>
@endsection
