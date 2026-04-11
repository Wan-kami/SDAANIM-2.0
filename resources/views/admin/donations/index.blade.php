@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Donaciones</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($donations->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donante</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Método de Pago</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($donations as $donation)
            <tr>
                <td>{{ $donation->Don_id }}</td>
                <td>{{ $donation->user->name ?? 'Anónimo' }}</td>
                <td>{{ $donation->Don_fecha }}</td>
                <td>${{ number_format($donation->Don_monto, 2) }}</td>
                <td>{{ $donation->Don_metodo_pago }}</td>
            </tr>
            @php $total += $donation->Don_monto; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #e9f7ef; font-weight: bold;">
                <td colspan="3">TOTAL</td>
                <td colspan="2">${{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    @else
    <p class="no-users">No hay donaciones registradas.</p>
    @endif
</main>
@endsection
