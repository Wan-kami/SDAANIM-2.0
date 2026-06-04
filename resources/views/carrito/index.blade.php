@extends('layouts.adopter.app')

@section('title', 'Carrito de Compras')

@section('content')

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <a href="{{ route('products.public') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver a Productos</a>

    <h1 style="color: #2d7d46; margin-bottom: 30px;">🛒 Mi Carrito</h1>

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

    @if($cartItems->isEmpty())
        <div style="background: white; padding: 40px; border-radius: 12px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <p style="font-size: 1.2em; color: #666; margin-bottom: 20px;">Tu carrito está vacío 📭</p>
            <a href="{{ route('products.public') }}" style="background: #2d7d46; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">
                Ir a Productos
            </a>
        </div>
    @else
        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #2d7d46; color: white;">
                    <tr>
                        <th style="padding: 15px; text-align: left;">Producto</th>
                        <th style="padding: 15px; text-align: center;">Precio Unitario</th>
                        <th style="padding: 15px; text-align: center;">Cantidad</th>
                        <th style="padding: 15px; text-align: center;">Subtotal</th>
                        <th style="padding: 15px; text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        @php
                            $subtotal = $item->product->prod_precio * $item->cart_cantidad;
                        @endphp
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 15px; display: flex; gap: 15px; align-items: center;">
                                @if($item->product->prod_imagen)
                                    <img src="{{ asset('img/' . $item->product->prod_imagen) }}" alt="{{ $item->product->prod_nombre }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">📦</div>
                                @endif
                                <div>
                                    <strong style="display: block; margin-bottom: 5px;">{{ $item->product->prod_nombre }}</strong>
                                    <small style="color: #666;">{{ $item->product->prod_categoria }}</small>
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: center; font-weight: bold;">${{ number_format($item->product->prod_precio, 0) }}</td>
                            <td style="padding: 15px; text-align: center;">
                                <form action="{{ route('cart.update-quantity', $item->cart_id) }}" method="POST" style="display: inline; display: flex; gap: 5px; align-items: center; justify-content: center;">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $item->cart_cantidad }}" min="1" max="{{ $item->product->prod_cantidad }}" style="width: 50px; padding: 5px; border: 1px solid #ddd; border-radius: 5px; text-align: center;">
                                    <button type="submit" style="background: #0ea5e9; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">✓</button>
                                </form>
                            </td>
                            <td style="padding: 15px; text-align: center; font-weight: bold;">${{ number_format($subtotal, 0) }}</td>
                            <td style="padding: 15px; text-align: center;">
                                <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px; display: grid; grid-template-columns: auto auto; gap: 20px; justify-content: flex-end;">
            <div style="background: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <p style="margin: 10px 0; font-size: 1.1em;">
                    <strong>Total a Pagar:</strong>
                    <span style="color: #2d7d46; font-size: 1.3em;">${{ number_format($total, 0) }}</span>
                </p>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: flex-end;">
            <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: #e2e8f0; color: #475569; padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    Vaciar Carrito
                </button>
            </form>

            <form action="{{ route('orders.checkout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: #2d7d46; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 1em;">
                    Confirmar Pedido
                </button>
            </form>
        </div>

        <div style="margin-top: 30px; background: #fffbeb; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b;">
            <strong style="color: #b45309;">⏰ Importante:</strong>
            <p style="color: #92400e; margin-top: 8px;">
                Tienes <strong>5 horas</strong> para recoger tu pedido en el refugio. Si no lo recoges en ese tiempo, será automáticamente cancelado y los productos regresarán al inventario.
            </p>
        </div>
    @endif
</div>

@endsection
