@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Adoptantes Registrados</h2>

    @if($adoptants->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adoptants as $adoptant)
            <tr>
                <td>{{ $adoptant->Usu_documento }}</td>
                <td>{{ $adoptant->name }}</td>
                <td>{{ $adoptant->email }}</td>
                <td>{{ $adoptant->Usu_telefono ?? 'N/A' }}</td>
                <td>{{ $adoptant->Usu_direccion ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay adoptantes registrados.</p>
    @endif
</main>
@endsection
