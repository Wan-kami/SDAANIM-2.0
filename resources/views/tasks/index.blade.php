@extends($layout)

@section('title', 'Mis Tareas | SDAANIM')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">

    <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; background: #ffffff; color: #475569; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.95em; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.borderColor='#cbd5e1'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='#ffffff'; this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Volver al Panel
    </a>
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
                $colors = $task->status_colors;
            @endphp

            <div class="task-card" style="border-left-color: {{ $colors['border'] }};">
                <div class="task-header">
                    {{-- Info --}}
                    <div>
                        <h3 class="task-title">{{ $task->Tar_titulo }}</h3>
                        <p class="task-desc">{{ $task->Tar_descripcion }}</p>

                        <p><strong>Base:</strong> {{ $task->Tar_base ?? 'Centro Principal' }}</p>
                        <p><strong>Asignada el:</strong> {{ $task->Tar_fecha_asignacion ? $task->Tar_fecha_asignacion->format('d/m/Y') : '-' }}</p>
                        <p>
                            <strong>Fecha de visita:</strong>
                            {{ $task->Tar_fecha_limite ? $task->Tar_fecha_limite->format('d/m/Y') : '-' }}
                            @if($task->Tar_hora) a las {{ $task->Tar_hora }} @endif
                        </p>
                    </div>

                    {{-- Estado --}}
                    <span class="task-badge" style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }};">
                        {{ $estado }}
                    </span>
                </div>

                <hr style="margin: 15px 0;">

                {{-- ACCIONES --}}
                @if($estado !== 'Completado')

                    <div class="task-actions">
                        {{-- Cambiar a Observación --}}
                        @if($estado == 'Pendiente')
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="Observación">
                                <button class="task-btn btn-observation">Observación</button>
                            </form>
                        @endif

                        {{-- Cambiar a En Proceso --}}
                        @if($estado == 'Pendiente' || $estado == 'Observación')
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="En Proceso">
                                <button class="task-btn btn-process">En Proceso</button>
                            </form>
                        @endif
                    </div>

                    {{-- Información del adoptante para adopciones --}}
                    @if($task->adoptionRequest)
                        <div class="adoption-info-box">
                            <h4 class="adoption-info-title">📋 Información del Adoptante</h4>
                            <p><strong>Nombre:</strong> {{ optional($task->adoptionRequest->user)->name }}</p>
                            <p><strong>Teléfono:</strong> {{ optional($task->adoptionRequest->user)->Usu_telefono ?? 'No especificado' }}</p>
                            <p><strong>Dirección:</strong> {{ optional($task->adoptionRequest->user)->Usu_direccion ?? 'No especificada' }}</p>
                            <p><strong>Animal solicitado:</strong> {{ optional($task->adoptionRequest->animal)->Anim_nombre }}</p>
                            <p><strong>Motivo:</strong> {{ $task->adoptionRequest->Soli_motivo }}</p>
                            <p><strong>Otras mascotas:</strong> {{ $task->adoptionRequest->Soli_otras_mascotas ?? 'Ninguna' }}</p>
                            <p><strong>Tipo de vivienda:</strong> {{ $task->adoptionRequest->Soli_tipo_vivienda }}</p>
                            <p><strong>Tiempo disponible:</strong> {{ $task->adoptionRequest->Soli_tiempo_disponible }}</p>
                            @if($task->adoptionRequest->Soli_comentarios)
                                <p><strong>Comentarios adicionales:</strong> {{ $task->adoptionRequest->Soli_comentarios }}</p>
                            @endif
                        </div>
                    @endif

                    {{-- Formulario especial para adopciones --}}
                    @if($task->adoptionRequest && !$task->adoptionRequest->reporte_voluntario)
                        <form action="{{ route('admin.adoptions.report', $task->adoptionRequest->Soli_id) }}" method="POST" class="task-form-box">
                            @csrf
                            <label class="task-form-label">Reporte de Visita de Adopción</label>
                            <textarea name="reporte" rows="4" class="task-form-textarea" placeholder="Describe lo que observaste en el hogar del adoptante, condiciones, etc." required></textarea>
                            <div style="margin-bottom: 10px;">
                                <label><input type="radio" name="apto" value="1" required> Apto para adopción</label>
                                <label style="margin-left: 20px;"><input type="radio" name="apto" value="0" required> No apto para adopción</label>
                            </div>
                            <button class="task-btn btn-success">✓ Enviar Reporte</button>
                        </form>
                    @else
                        <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST" class="task-form-box">
                            @csrf
                            <label class="task-form-label">📤 Enviar Reporte al Administrador</label>
                            <div style="display:flex; gap:10px; flex-direction: column;">
                                <textarea name="comentario" rows="2" class="task-form-textarea" placeholder="Describe lo que realizaste o observaste (el admin revisará y aprobará la tarea)">{{ $task->Tar_comentario }}</textarea>
                                <button class="task-btn btn-success" style="align-self: flex-start;">📤 Enviar Reporte</button>
                            </div>
                        </form>
                    @endif

                @else
                    {{-- Editar Comentario --}}
                    <div class="task-form-box">
                        <h4 style="margin: 0 0 10px 0; color: #155724;">✅ Tarea Completada</h4>
                        <form action="{{ route($routePrefix . '.tasks.updateComment', $task->Tar_id) }}" method="POST">
                            @csrf
                            <label class="task-form-label">Tus Observaciones:</label>
                            <div style="display:flex; gap:10px; margin-top: 5px;">
                                <textarea name="comentario" rows="2" class="task-form-textarea" placeholder="Puedes agregar o corregir tus observaciones.">{{ $task->Tar_comentario }}</textarea>
                                <button class="task-btn btn-update">Actualizar</button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        @empty
            <div class="task-empty">
                <span style="font-size: 3em;">✨</span>
                <h3 style="color: #64748b;">No tienes tareas pendientes</h3>
                <p>Excelente trabajo. Si quieres ver tus labores anteriores, visita tu sección de progreso.</p>
                <a href="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.progress' : 'volunteer.progress') }}" style="display:inline-block; margin-top:10px; background:#0ea5e9; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:bold;">📈 Ver Mi Progreso</a>
            </div>
        @endforelse

    </div>
</div>
@endsection