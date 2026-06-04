@extends('layouts.adopter.app')

@section('title', 'Productos')

@section('content')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 40px;">
        <div>
            <h1 style="color: #2d7d46; margin: 0 0 10px 0;">🛍️ Catálogo de Productos</h1>
            <p style="color: #64748b; margin: 0;">Encuentra todo lo que necesitas para cuidar a tus mascotas</p>
        </div>
        <a href="{{ route('cart.view') }}" style="background: #2d7d46; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 10px;">
            🛒 Ver Carrito
        </a>
    </div>

    <form action="{{ route('products.public') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 30px;">
        <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="Buscar por nombre o descripción"
            style="flex:1; min-width:220px; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 10px;"
        />
        <select name="category" style="min-width:220px; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 10px;">
            <option value="">Todas las categorías</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
            @endforeach
        </select>
        <button type="submit" style="background: #2d7d46; color: white; border: none; padding: 12px 20px; border-radius: 10px; font-weight: bold; cursor: pointer;">Filtrar</button>
    </form>

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
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
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

                        <!-- COLORES DISPONIBLES (Solo para Ropa) -->
                        @if($product->prod_categoria === 'Ropa' && $product->colors->count() > 0)
                        <div style="margin: 15px 0; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                            <label style="font-weight: 600; font-size: 0.85em; color: #333; display: block; margin-bottom: 8px;">
                                🎨 Colores Disponibles:
                            </label>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($product->colors->where('disponible', true) as $color)
                                <div style="display: flex; align-items: center; gap: 5px; padding: 4px 8px; background: white; border-radius: 4px; border: 1px solid #ddd;">
                                    @if($color->color_hex)
                                    <div style="width: 16px; height: 16px; background-color: {{ $color->color_hex }}; border-radius: 3px; border: 1px solid #ccc;"></div>
                                    @endif
                                    <span style="font-size: 0.8em; color: #666;">{{ $color->color_nombre }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- TALLAS DISPONIBLES (Solo para Ropa) -->
                        @if($product->prod_categoria === 'Ropa' && $product->sizes->count() > 0)
                        <div style="margin: 15px 0; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                            <label style="font-weight: 600; font-size: 0.85em; color: #333; display: block; margin-bottom: 8px;">
                                📏 Tallas Disponibles:
                            </label>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($product->sizes->where('disponible', true) as $size)
                                <span style="padding: 5px 10px; background: white; border: 1px solid #2d7d46; color: #2d7d46; border-radius: 4px; font-weight: 600; font-size: 0.85em;">
                                    {{ $size->talla }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

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
