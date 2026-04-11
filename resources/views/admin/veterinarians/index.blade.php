@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Veterinarios Postulados</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($veterinarians->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Certificado</th>
                <th>Comentarios</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($veterinarians as $vet)
            <tr>
                <td>{{ $vet->ins_id }}</td>
                <td>{{ $vet->ins_documento }}</td>
                <td>{{ $vet->ins_nombre }}</td>
                <td>{{ $vet->ins_email }}</td>
                <td>{{ $vet->ins_telefono }}</td>
                <td>{{ $vet->ins_direccion }}</td>
                <td>
                    @if(!empty($vet->ins_certificado))
                    <a href="{{ asset('storage/uploads/' . $vet->ins_certificado) }}" target="_blank">Ver Certificado</a>
                    @else
                    No adjuntó
                    @endif
                </td>
                <td>{{ $vet->ins_comentario }}</td>
                <td>{{ $vet->ins_estado }}</td>
                <td>
                    @if($vet->ins_estado == 'Pendiente')
                    <form action="{{ route('admin.veterinarians.process') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $vet->ins_id }}">
                        <input type="hidden" name="accion" value="aceptar">
                        <button type="submit">Aceptar</button>
                    </form>
                    <form action="{{ route('admin.veterinarians.process') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $vet->ins_id }}">
                        <input type="hidden" name="accion" value="rechazar">
                        <button type="submit">Rechazar</button>
                    </form>
                    @else
                    <span>{{ $vet->ins_estado }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay veterinarios postulados.</p>
    @endif
</main>
@endsection
