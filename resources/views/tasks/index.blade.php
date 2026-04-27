@php
    $layout = Auth::user()->role == 'Veterinario' ? 'layouts.vet.app' : 'layouts.volunteer.app';
@endphp

@extends($layout)

@section('title', 'Mis Tareas | SDAANIM')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">

    <h2>Mis Tareas Asignadas</h2>
    <p>Lista de actividades pendientes para el refugio.</p>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-top: 20px;">
        @forelse($tasks as $task)

            @php
                $estado = $task->Tar_estado;
                $routePrefix = Auth::user()->role == 'Veterinario' ? 'vet' : 'volunteer';

                $colores = [
                    'Pendiente' => ['bg' => '#fff3cd', 'text' => '#856404', 'border' => '#ffc107'],
                    'Observación' => ['bg' => '#d1ecf1', 'text' => '#0c5460', 'border' => '#17a2b8'],
                    'En Proceso' => ['bg' => '#ffeaa7', 'text' => '#d68910', 'border' => '#fd7e14'],
                    'Completado' => ['bg' => '#d4edda', 'text' => '#155724', 'border' => '#28a745'],
                ];
            @endphp

            <div style="
                background: white;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                margin-bottom: 20px;
                border-left: 5px solid {{ $colores[$estado]['border'] ?? '#ccc' }};
            ">

                <div style="display: flex; justify-content: space-between; align-items: flex-start;">

                    {{-- Info --}}
                    <div>
                        <h3 style="margin: 0; color: #2e8b57;">{{ $task->Tar_titulo }}</h3>
                        <p style="margin: 10px 0; color: #444;">{{ $task->Tar_descripcion }}</p>

                        <p><strong>Base:</strong> {{ $task->Tar_base ?? 'Centro Principal' }}</p>
                        <p><strong>Asignada el:</strong> {{ $task->Tar_fecha_asignacion ? $task->Tar_fecha_asignacion->format('d/m/Y') : '-' }}</p>
                        <p>
                            <strong>Fecha de visita:</strong>
                            {{ $task->Tar_fecha_limite ? $task->Tar_fecha_limite->format('d/m/Y') : '-' }}
                            @if($task->Tar_hora) a las {{ $task->Tar_hora }} @endif
                        </p>
                    </div>

                    {{-- Estado --}}
                    <span style="
                        padding: 5px 12px;
                        border-radius: 20px;
                        font-size: 0.8em;
                        font-weight: bold;
                        background: {{ $colores[$estado]['bg'] ?? '#f1f5f9' }};
                        color: {{ $colores[$estado]['text'] ?? '#475569' }};
                    ">
                        {{ $estado }}
                    </span>
                </div>

                <hr style="margin: 15px 0;">

                {{-- ACCIONES --}}
                @if($estado !== 'Completado')

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">

                        {{-- Cambiar a Observación --}}
                        @if($estado == 'Pendiente')
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="Observación">
                                <button style="background:#17a2b8;color:#fff;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;">
                                    Observación
                                </button>
                            </form>
                        @endif

                        {{-- Cambiar a En Proceso --}}
                        @if($estado == 'Pendiente' || $estado == 'Observación')
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="En Proceso">
                                <button style="background:#fd7e14;color:#fff;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;">
                                    En Proceso
                                </button>
                            </form>
                        @endif

                        {{-- Completar --}}
                    </div>

                    {{-- Información del adoptante para adopciones --}}
                    @if($task->soli_id || str_contains(strtolower($task->Tar_descripcion), 'seguimiento') || str_contains(strtolower($task->Tar_descripcion), 'adopción') || str_contains(strtolower($task->Tar_descripcion), 'visita'))
                        @php
                            if ($task->soli_id) {
                                $adoptionRequest = \App\Models\AdoptionRequest::with('user', 'animal')->find($task->soli_id);
                            } else {
                                $adoptionRequest = \App\Models\AdoptionRequest::where('Soli_voluntario', Auth::user()->Usu_documento)
                                    ->where('Soli_estado', 'En Revisión')
                                    ->with('user', 'animal')
                                    ->first();
                            }
                        @endphp
                        @if($adoptionRequest)
                            <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #0ea5e9;">
                                <h4 style="margin: 0 0 10px 0; color: #0ea5e9;">📋 Información del Adoptante</h4>
                                <p><strong>Nombre:</strong> {{ $adoptionRequest->user->name }}</p>
                                <p><strong>Teléfono:</strong> {{ $adoptionRequest->user->Usu_telefono ?? 'No especificado' }}</p>
                                <p><strong>Dirección:</strong> {{ $adoptionRequest->user->Usu_direccion ?? 'No especificada' }}</p>
                                <p><strong>Animal solicitado:</strong> {{ $adoptionRequest->animal->Anim_nombre }}</p>
                                <p><strong>Motivo:</strong> {{ $adoptionRequest->Soli_motivo }}</p>
                                <p><strong>Otras mascotas:</strong> {{ $adoptionRequest->Soli_otras_mascotas ?? 'Ninguna' }}</p>
                                <p><strong>Tipo de vivienda:</strong> {{ $adoptionRequest->Soli_tipo_vivienda }}</p>
                                <p><strong>Tiempo disponible:</strong> {{ $adoptionRequest->Soli_tiempo_disponible }}</p>
                                @if($adoptionRequest->Soli_comentarios)
                                    <p><strong>Comentarios adicionales:</strong> {{ $adoptionRequest->Soli_comentarios }}</p>
                                @endif
                            </div>
                        @endif
                    @endif

                    {{-- Formulario especial para adopciones --}}
                    @if(str_contains(strtolower($task->Tar_descripcion), 'seguimiento') || str_contains(strtolower($task->Tar_descripcion), 'adopción') || str_contains(strtolower($task->Tar_descripcion), 'visita'))
                        @php
                            $adoptionRequest = \App\Models\AdoptionRequest::where('Soli_voluntario', Auth::user()->Usu_documento)
                                ->where('Soli_estado', 'En Revisión')
                                ->first();
                        @endphp
                        @if($adoptionRequest && !$adoptionRequest->reporte_voluntario)
                            <form action="{{ route('admin.requests.submitReport', $adoptionRequest->Soli_id) }}" method="POST" style="width: 100%; margin-top: 15px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                @csrf
                                <label style="font-size:0.9em; font-weight: bold; color: #333; display: block; margin-bottom: 5px;">Reporte de Visita de Adopción</label>
                                <textarea name="reporte" rows="4" placeholder="Describe lo que observaste en el hogar del adoptante, condiciones, etc." required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom: 10px;"></textarea>
                                <div style="margin-bottom: 10px;">
                                    <label><input type="radio" name="apto" value="1" required> Apto para adopción</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="apto" value="0" required> No apto para adopción</label>
                                </div>
                                <button style="background:#28a745;color:#fff;padding:10px 20px;border:none;border-radius:8px;cursor:pointer; font-weight: bold;">
                                    ✓ Enviar Reporte
                                </button>
                            </form>
                        @else
                            <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST" style="width: 100%; margin-top: 15px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                @csrf
                                <label style="font-size:0.9em; font-weight: bold; color: #333; display: block; margin-bottom: 5px;">Completar Tarea (Observaciones)</label>
                                <div style="display:flex; gap:10px; flex-direction: column;">
                                    <textarea name="comentario" rows="2" placeholder="Describe lo que observaste o realizaste (opcional)" style="flex:1; padding:10px; border-radius:8px; border:1px solid #ddd;">{{ $task->Tar_comentario }}</textarea>
                                    <button style="background:#28a745;color:#fff;padding:10px 20px;border:none;border-radius:8px;cursor:pointer; align-self: flex-start; font-weight: bold;">
                                        ✓ Completar Tarea
                                    </button>
                                </div>
                            </form>
                        @endif
                    @else
                        <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST" style="width: 100%; margin-top: 15px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            @csrf
                            <label style="font-size:0.9em; font-weight: bold; color: #333; display: block; margin-bottom: 5px;">Completar Tarea (Observaciones)</label>
                            <div style="display:flex; gap:10px; flex-direction: column;">
                                <textarea name="comentario" rows="2" placeholder="Describe lo que observaste o realizaste (opcional)" style="flex:1; padding:10px; border-radius:8px; border:1px solid #ddd;">{{ $task->Tar_comentario }}</textarea>
                                <button style="background:#28a745;color:#fff;padding:10px 20px;border:none;border-radius:8px;cursor:pointer; align-self: flex-start; font-weight: bold;">
                                    ✓ Completar Tarea
                                </button>
                            </div>
                        </form>
                    @endif

                @else
                    {{-- Editar Comentario --}}
                    <div style="background:#f8f9fa;padding:15px;border-radius:8px;">
                        <h4 style="margin: 0 0 10px 0; color: #155724;">✅ Tarea Completada</h4>
                        <form action="{{ route($routePrefix . '.tasks.updateComment', $task->Tar_id) }}" method="POST">
                            @csrf
                            <label style="font-size:0.9em; font-weight: bold;">Tus Observaciones:</label>
                            <div style="display:flex; gap:10px; margin-top: 5px;">
                                <textarea name="comentario" rows="2" placeholder="Puedes agregar o corregir tus observaciones." style="flex:1; padding:10px; border-radius:8px; border:1px solid #ddd;">{{ $task->Tar_comentario }}</textarea>
                                <button style="background:#0ea5e9;color:#fff;padding:10px 20px;border:none;border-radius:8px;cursor:pointer; font-weight: bold;">
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        @empty
            <div style="text-align:center;padding:40px; background: white; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 5px solid #6c757d;">
                <span style="font-size: 3em;">✨</span>
                <h3 style="color: #64748b;">No tienes tareas pendientes</h3>
                <p>Excelente trabajo. Si quieres ver tus labores anteriores, visita tu sección de progreso.</p>
                <a href="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.progress' : 'volunteer.progress') }}" style="display:inline-block; margin-top:10px; background:#0ea5e9; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:bold;">📈 Ver Mi Progreso</a>
            </div>
        @endforelse

        <a href="{{ route('dashboard') }}" style="display:inline-block;margin-top:20px;background:#6c757d;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;">
            ← Volver
        </a>

    </div>
</div>
@endsection