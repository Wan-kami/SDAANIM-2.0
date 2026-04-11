@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Solicitudes de Adopción</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($adoptions->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Animal</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Voluntario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adoptions as $adoption)
            <tr>
                <td>{{ $adoption->Soli_id }}</td>
                <td>{{ $adoption->user->name ?? $adoption->Usu_documento }}</td>
                <td>{{ $adoption->animal->Anim_nombre ?? 'N/A' }}</td>
                <td>{{ $adoption->Soli_fecha->format('d/m/Y') }}</td>
                <td>
                    @if($adoption->Soli_estado == 'Pendiente')
                    <span class="badge" style="background-color: #FFC107;">Pendiente</span>
                    @elseif($adoption->Soli_estado == 'En Revisión')
                    <span class="badge" style="background-color: #2196F3;">En Revisión</span>
                    @elseif($adoption->Soli_estado == 'Aceptada')
                    <span class="badge" style="background-color: #4CAF50;">Aceptada</span>
                    @elseif($adoption->Soli_estado == 'Rechazada')
                    <span class="badge" style="background-color: #f44336;">Rechazada</span>
                    @endif
                </td>
                <td>{{ $adoption->volunteer->name ?? 'Sin asignar' }}</td>
                <td>
                    <a href="{{ route('admin.adoptions.show', $adoption->Soli_id) }}" style="padding: 5px 10px; background-color: #2196F3; color: white; border-radius: 4px; text-decoration: none;">Ver Detalle</a>
                    
                    @if($adoption->Soli_estado == 'Pendiente')
                    <a href="{{ route('admin.adoptions.assign', $adoption->Soli_id) }}" class="btn-asignar" style="padding: 5px 10px;">Asignar</a>
                    @endif
                    
                    @if($adoption->Soli_estado == 'En Revisión' && $adoption->followups && $adoption->followups->count() > 0)
                    <a href="{{ route('admin.adoptions.approve', $adoption->Soli_id) }}" class="btn-ok" style="padding: 5px 10px;">Aprobar</a>
                    <a href="{{ route('admin.adoptions.reject', $adoption->Soli_id) }}" class="btn-cancel" style="padding: 5px 10px;">Rechazar</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay solicitudes de adopción.</p>
    @endif
</main>
@endsection
