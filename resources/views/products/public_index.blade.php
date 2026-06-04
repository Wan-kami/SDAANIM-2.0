@extends('layouts.adopter.app')

@section('title', 'Productos')

@section('content')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="color: #2d7d46; margin: 0 0 10px 0;">🛍️ Catálogo de Productos</h1>
            <p style="color: #64748b; margin: 0;">Encuentra todo lo que necesitas para cuidar a tus mascotas</p>
        </div>
        <a href="{{ route('cart.view') }}" style="background: #2d7d46; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 10px;">
            🛒 Ver Carrito
        </a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
            {{ session('error') }}
        </div>
    @endif

    @if($products->isEmpty())
        <div style="background: white; padding: 60px 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <p style="font-size: 1.2em; color: #666;">No hay productos disponibles por ahora</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px;">
            @foreach($products as $product)
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <!-- Imagen -->
                    @if($product->prod_imagen)
                        <img src="{{ asset('img/' . $product->prod_imagen) }}" alt="{{ $product->prod_nombre }}" 
                            style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 3em;">📦</div>
                    @endif

                    <!-- Contenido -->
                    <div style="padding: 20px;">
                        <h3 style="margin: 0 0 10px 0; color: #1f4335; font-size: 1.1em;">{{ $product->prod_nombre }}</h3>
                        
                        <p style="margin: 0 0 10px 0; color: #64748b; font-size: 0.9em;">
                            {{ Str::limit($product->prod_descripcion, 80) }}
                        </p>

                        <div style="margin: 15px 0; padding: 10px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
                            <span style="background: #f0fdf4; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold;">
                                {{ $product->prod_categoria }}
                            </span>
                            <span style="margin-left: 10px; color: #666; font-size: 0.9em;">
                                Stock: <span style="font-weight: bold;">{{ $product->prod_cantidad }}</span>
                            </span>
                        </div>

                        <p style="margin: 15px 0 20px 0; font-size: 1.5em; color: #2d7d46; font-weight: bold;">
                            ${{ number_format($product->prod_precio, 0) }}
                        </p>

                        @if($product->prod_cantidad > 0)
                            <form action="{{ route('cart.add', $product->prod_id) }}" method="POST" style="display: flex; gap: 10px;">
                                @csrf
                                <input type="number" name="cantidad" value="1" min="1" max="{{ $product->prod_cantidad }}" 
                                    style="width: 60px; padding: 8px; border: 1px solid #ddd; border-radius: 5px; text-align: center;">
                                <button type="submit" style="flex: 1; background: #2d7d46; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                                    Agregar al Carrito
                                </button>
                            </form>
                        @else
                            <button disabled style="width: 100%; background: #ccc; color: #666; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: not-allowed;">
                                Agotado
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
