@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Reservas Pendientes</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($reservations->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Producto</th>
                <th>Valor a pagar</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->user->name ?? 'N/A' }}</td>
                <td>{{ $reservation->usuario_id }}</td>
                <td>{{ $reservation->product->prod_nombre ?? 'N/A' }}</td>
                <td>$ {{ number_format($reservation->product->prod_precio ?? 0, 2) }}</td>
                <td>{{ $reservation->re_fecha }}</td>
                <td>
                    <a href="{{ route('admin.reservations.paid', $reservation->re_id) }}">Pagado</a>
                    |
                    <a href="{{ route('admin.reservations.cancel', $reservation->re_id) }}" onclick="return confirm('¿Cancelar reserva?')">Cancelar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay reservas pendientes.</p>
    @endif
</main>
@endsection
