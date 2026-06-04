@extends('layouts.adopter.app')

@section('title', 'Historial de Pedidos')

@section('content')

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver</a>

    <h1 style="color: #2d7d46; margin-bottom: 30px;">📋 Historial de Pedidos</h1>

    @if($orders->isEmpty())
        <div style="background: white; padding: 40px; border-radius: 12px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <p style="font-size: 1.2em; color: #666;">No tienes pedidos aún</p>
        </div>
    @else
        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #2d7d46; color: white;">
                    <tr>
                        <th style="padding: 15px; text-align: left;">Fecha</th>
                        <th style="padding: 15px; text-align: center;">Estado</th>
                        <th style="padding: 15px; text-align: center;">Total</th>
                        <th style="padding: 15px; text-align: center;">Vencimiento</th>
                        <th style="padding: 15px; text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 15px;">{{ $order->ord_fechaCreacion->format('d/m/Y H:i') }}</td>
                            <td style="padding: 15px; text-align: center;">
                                @php
                                    $colores = [
                                        'pendiente' => ['bg' => '#fef3c7', 'text' => '#b45309'],
                                        'confirmado' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                                        'recogido' => ['bg' => '#dcfce7', 'text' => '#166534'],
                                        'cancelado' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                    ];
                                    $color = $colores[$order->ord_estado] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                                @endphp
                                <span style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 6px 12px; border-radius: 20px; font-weight: bold; text-transform: uppercase; font-size: 0.85em;">
                                    {{ ucfirst($order->ord_estado) }}
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center; font-weight: bold;">${{ number_format($order->ord_total, 0) }}</td>
                            <td style="padding: 15px; text-align: center;">
                                @if($order->ord_estado === 'pendiente')
                                    <span style="color: {{ Carbon\Carbon::parse($order->ord_fechaExpiracion)->isPast() ? '#991b1b' : '#166534' }};">
                                        {{ $order->ord_fechaExpiracion->format('d/m/Y H:i') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ route('orders.show', $order->ord_id) }}" style="background: #0ea5e9; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Ver Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
