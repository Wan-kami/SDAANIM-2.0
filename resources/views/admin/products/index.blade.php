@extends('layouts.app')

@section('content')
<main class="products-main">
    <!-- Professional Header -->
    <div class="professional-header-prod">
        <div class="header-content-prod">
            <a href="{{ route('admin.dashboard') }}" class="btn-back-prod" title="Volver al Panel">
                <span class="back-icon-prod">←</span>
            </a>
            <div>
                <h1>📦 Gestión de Productos</h1>
                <p class="subtitle">Administra los productos y accesorios para las mascotas</p>
            </div>
        </div>
    </div>

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

        <a href="{{ route('admin.products.create') }}" class="adopta-card add-card">
            <img src="{{ asset('img/agregar.png') }}" alt="Agregar nuevo">
            <h3>Agregar nuevo producto</h3>
        </a>
    </div>
</main>

<style>
    .products-main {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Professional Header Styles */
    .professional-header-prod {
        margin-bottom: 2rem;
    }

    .header-content-prod {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .header-content-prod h1 {
        font-size: 2rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .header-content-prod .subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    /* Back Button */
    .btn-back-prod {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 50%;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 1rem;
        font-size: 1.2rem;
        border: 2px solid #e0e0e0;
    }

    .btn-back-prod:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: scale(1.1);
    }

    .back-icon-prod {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@endsection
