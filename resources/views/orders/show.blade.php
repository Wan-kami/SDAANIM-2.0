@extends('layouts.adopter.app')

@section('title', 'Detalles del Pedido')

@section('content')

<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <a href="{{ route('orders.history') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Historial</a>

    <h1 style="color: #2d7d46; margin-bottom: 30px;">Pedido #{{ $order->ord_id }}</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="color: #2d7d46; margin-bottom: 15px;">Información del Pedido</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;"><strong>Estado:</strong> 
                    @php
                        $colores = [
                            'pendiente' => ['bg' => '#fef3c7', 'text' => '#b45309'],
                            'confirmado' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                            'recogido' => ['bg' => '#dcfce7', 'text' => '#166534'],
                            'cancelado' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                        ];
                        $color = $colores[$order->ord_estado] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                    @endphp
                    <span style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 4px 8px; border-radius: 4px; font-weight: bold;">{{ ucfirst($order->ord_estado) }}</span>
                </li>
                <li style="margin-bottom: 10px;"><strong>Fecha Creación:</strong> {{ $order->ord_fechaCreacion->format('d/m/Y H:i') }}</li>
                <li style="margin-bottom: 10px;"><strong>Fecha Vencimiento:</strong> {{ $order->ord_fechaExpiracion->format('d/m/Y H:i') }}</li>
                @if($order->ord_fechaRecogida)
                    <li style="margin-bottom: 10px;"><strong>Fecha Recogida:</strong> {{ $order->ord_fechaRecogida->format('d/m/Y H:i') }}</li>
                @endif
            </ul>
        </div>

        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="color: #2d7d46; margin-bottom: 15px;">Resumen Financiero</h3>
            <div style="font-size: 1.5em; font-weight: bold; color: #2d7d46;">
                Total: ${{ number_format($order->ord_total, 0) }}
            </div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <h3 style="color: #2d7d46; margin-bottom: 20px;">Productos en el Pedido</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f3f4f6;">
                <tr>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Producto</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #ddd;">Cantidad</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #ddd;">Precio Unitario</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #ddd;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">{{ $item->product->prod_nombre }}</td>
                        <td style="padding: 12px; text-align: center;">{{ $item->oit_cantidad }}</td>
                        <td style="padding: 12px; text-align: center;">${{ number_format($item->oit_precio_unitario, 0) }}</td>
                        <td style="padding: 12px; text-align: center; font-weight: bold;">${{ number_format($item->oit_subtotal, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($order->ord_estado === 'pendiente')
        <div style="background: #fffbeb; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 20px;">
            <strong style="color: #b45309;">⏰ Recordatorio:</strong>
            <p style="color: #92400e; margin-top: 8px;">
                Tu pedido vence el <strong>{{ $order->ord_fechaExpiracion->format('d/m/Y H:i') }}</strong>. 
                Debes recogerlo en el refugio antes de esa fecha y hora, de lo contrario será automáticamente cancelado.
            </p>
        </div>
    @endif
</div>

@endsection
