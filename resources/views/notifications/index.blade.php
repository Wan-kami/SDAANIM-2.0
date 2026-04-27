@php
    $layout = match(Auth::user()->role) {
        'Administrador' => 'layouts.admin.app',
        'Veterinario' => 'layouts.vet.app',
        'Adoptante' => 'layouts.adopter.app',
        default => 'layouts.volunteer.app',
    };
@endphp

@extends($layout)

@section('title', 'Notificaciones | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2>Centro de Notificaciones</h2>
            <p>Todas tus actividades y actualizaciones en un solo lugar.</p>
        </div>
        <a href="{{ route('dashboard') }}" style="text-decoration: none; background: #374151; color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600;">← Volver</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($notifications->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <p style="font-size: 1.1em; color: #666;">📭 No tienes notificaciones</p>
        </div>
    @else
        <div style="margin-top: 20px;">
            @foreach($notifications as $notif)
                <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 15px; border-left: 5px solid #0ea5e9; position: relative; display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">{{ $notif->Noti_mensaje }}</p>
                        <p style="margin: 0; font-size: 0.85em; color: #64748b;">
                            <strong>Fecha:</strong> {{ $notif->Noti_fecha ? $notif->Noti_fecha->format('d/m/Y') : '-' }}
                        </p>
                        @if($notif->Noti_link)
                            <a href="{{ $notif->Noti_link }}" style="display: inline-block; margin-top: 8px; color: #0ea5e9; text-decoration: none; font-weight: 600; font-size: 0.9em;">
                                Ver más →
                            </a>
                        @endif
                    </div>
                    <form action="{{ route('notifications.delete', $notif->Noto_id) }}" method="POST" style="margin: 0; margin-left: 15px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; font-size: 1.3em; cursor: pointer; color: #94a3b8; transition: color 0.3s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'" title="Eliminar notificación">
                            ✕
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
