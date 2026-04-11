@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Voluntarios Postulados</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($volunteers->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Tipo de ayuda</th>
                <th>Comentarios</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($volunteers as $vol)
            <tr>
                <td>{{ $vol->ins_id }}</td>
                <td>{{ $vol->ins_documento }}</td>
                <td>{{ $vol->ins_nombre }}</td>
                <td>{{ $vol->ins_email }}</td>
                <td>{{ $vol->ins_telefono }}</td>
                <td>{{ $vol->ins_direccion }}</td>
                <td>{{ $vol->ins_tipo_ayuda }}</td>
                <td>{{ $vol->ins_comentario }}</td>
                <td>{{ $vol->ins_estado }}</td>
                <td>
                    @if($vol->ins_estado == 'Pendiente')
                    <form action="{{ route('admin.volunteers.process') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $vol->ins_id }}">
                        <input type="hidden" name="accion" value="aceptar">
                        <button type="submit">Aceptar</button>
                    </form>
                    <form action="{{ route('admin.volunteers.process') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $vol->ins_id }}">
                        <input type="hidden" name="accion" value="rechazar">
                        <button type="submit">Rechazar</button>
                    </form>
                    @else
                    <span>{{ $vol->ins_estado }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay voluntarios postulados.</p>
    @endif
</main>
@endsection
