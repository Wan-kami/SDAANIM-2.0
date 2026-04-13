@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Notificaciones</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if($notifications->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
            <tr>
                <td>{{ $notification->Noto_id }}</td>
                <td>{{ $notification->Usu_documento }}</td>
                <td>{{ $notification->Noti_mensaje }}</td>
                <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    @if($notification->Noti_link)
                    <a href="{{ $notification->Noti_link }}" style="padding: 5px 10px; background-color: #2196F3; color: white; border-radius: 4px; text-decoration: none;">Ver</a>
                    @endif
                    <a href="{{ route('admin.notifications.delete', $notification->Noto_id) }}" style="padding: 5px 10px; background-color: #dc3545; color: white; border-radius: 4px; text-decoration: none;" onclick="return confirm('¿Eliminar esta notificación?')">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-users">No hay notificaciones.</p>
    @endif
</main>
@endsection
