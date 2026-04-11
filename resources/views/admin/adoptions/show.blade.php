@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.adoptions') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Detalle de Solicitud #{{ $adoption->Soli_id }}</h2>

    <div class="admin-form" style="max-width: 800px;">
        <h3>Información del Solicitante</h3>
        <p><strong>Nombre:</strong> {{ $adoption->user->name ?? 'N/A' }}</p>
        <p><strong>Documento:</strong> {{ $adoption->Usu_documento }}</p>
        <p><strong>Email:</strong> {{ $adoption->user->email ?? 'N/A' }}</p>

        <h3>Información del Animal</h3>
        <p><strong>Nombre:</strong> {{ $adoption->animal->Anim_nombre ?? 'N/A' }}</p>
        <p><strong>Raza:</strong> {{ $adoption->animal->Anim_raza ?? 'N/A' }}</p>
        <p><strong>Edad:</strong> {{ $adoption->animal->Anim_edad ?? 'N/A' }}</p>

        <h3>Detalles de la Solicitud</h3>
        <p><strong>Fecha:</strong> {{ $adoption->Soli_fecha->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> {{ $adoption->Soli_estado }}</p>
        <p><strong>Motivo:</strong> {{ $adoption->Soli_motivo ?? 'No especificado' }}</p>
        <p><strong>Otras mascotas:</strong> {{ $adoption->Soli_otras_mascotas ?? 'No' }}</p>
        <p><strong>Tipo de vivienda:</strong> {{ $adoption->Soli_tipo_vivienda ?? 'No especificado' }}</p>
        <p><strong>Tiempo disponible:</strong> {{ $adoption->Soli_tiempo_disponible ?? 'No especificado' }}</p>
        <p><strong>Comentarios:</strong> {{ $adoption->Soli_comentarios ?? 'Sin comentarios' }}</p>

        @if($adoption->Soli_voluntario)
        <h3>Seguimiento</h3>
        <p><strong>Voluntario asignado:</strong> {{ $adoption->volunteer->name ?? 'N/A' }}</p>
        @endif

        <div style="margin-top: 20px;">
            @if($adoption->Soli_estado == 'Pendiente')
            <a href="{{ route('admin.adoptions.assign', $adoption->Soli_id) }}" class="btn-asignar" style="padding: 10px 20px;">Asignar Voluntario</a>
            @endif
            
            @if($adoption->Soli_estado == 'En Revisión')
            <a href="{{ route('admin.adoptions.approve', $adoption->Soli_id) }}" class="btn-ok" style="padding: 10px 20px;">Aprobar</a>
            <a href="{{ route('admin.adoptions.reject', $adoption->Soli_id) }}" class="btn-cancel" style="padding: 10px 20px;">Rechazar</a>
            @endif
        </div>
    </div>
</main>
@endsection
