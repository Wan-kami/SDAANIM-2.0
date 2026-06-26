@extends('layouts.adopter.app')

@section('title', 'Productos | SDAANIM')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">
@endsection

@section('content')

<div class="products-page-wrapper">

    <div class="products-page-header">
        <div>
            <h1>🛍️ Catálogo de Productos</h1>
            <p>Encuentra todo lo que necesitas para cuidar a tus mascotas</p>
        </div>
        <a href="{{ route('cart.view') }}" class="cart-btn">
            🛒 Ver Carrito
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($products->isEmpty())
        <div class="seccion" style="text-align:center; padding: 60px 20px;">
            <p style="font-size: 1.2rem; color: var(--brand-text-muted);">No hay productos disponibles por ahora</p>
        </div>
    @else
        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    {{-- Imagen --}}
                    @if($product->prod_imagen)
                        <img src="{{ asset('img/' . $product->prod_imagen) }}"
                             alt="{{ $product->prod_nombre }}"
                             class="product-card-img">
                    @else
                        <div class="product-card-img-placeholder">📦</div>
                    @endif

                    {{-- Contenido --}}
                    <div class="product-card-body">
                        <h3>{{ $product->prod_nombre }}</h3>
                        <p class="desc">{{ Str::limit($product->prod_descripcion, 80) }}</p>

                        <div class="product-meta">
                            <span class="product-category-tag">{{ $product->prod_categoria }}</span>
                            <span class="product-stock">Stock: <strong>{{ $product->prod_cantidad }}</strong></span>
                        </div>

                        <p class="product-price">${{ number_format($product->prod_precio, 0) }}</p>

                        @if($product->prod_cantidad > 0)
                            <form action="{{ route('cart.add', $product->prod_id) }}" method="POST">
                                @csrf
                                <div class="product-form-row">
                                    @if($product->talla)
                                        <select name="talla" required>
                                            <option value="">Talla</option>
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                        </select>
                                    @endif
                                    <input type="number" name="cantidad" value="1"
                                           min="1" max="{{ $product->prod_cantidad }}">
                                </div>
                                <button type="submit" class="btn-add-to-cart">Agregar al Carrito</button>
                            </form>
                        @else
                            <button class="btn-sold-out" disabled>Agotado</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
