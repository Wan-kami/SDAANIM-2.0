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
                $esAdopcion = $task->adoptionRequest || $task->soli_id || str_contains(strtolower($task->Tar_titulo), 'adop');
                $reporteEnviado = $esAdopcion
                    ? !empty($task->adoptionRequest->reporte_voluntario)
                    : ($estado === 'En Proceso' && !empty($task->Tar_comentario));
                $adoptionRequestId = $task->adoptionRequest->Soli_id ?? $task->soli_id;
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
                        {{-- Cambiar a Observación (solo tareas normales, no de adopción) --}}
                        @if($estado == 'Pendiente' && !$esAdopcion)
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="Observación">
                                <button class="task-btn btn-observation">Observación</button>
                            </form>
                        @endif

                        {{-- Cambiar a En Proceso (solo tareas normales, no de adopción) --}}
                        @if(($estado == 'Pendiente' || $estado == 'Observación') && !$esAdopcion)
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

                    @if($reporteEnviado)
                        {{-- ===================== BANNER: ya se envió el reporte ===================== --}}
                        <div style="background: #e0f2fe; color: #0369a1; padding: 15px; border-radius: 8px; border: 1px solid #bae6fd; margin-top: 15px;">
                            <h4 style="margin: 0 0 8px 0; display: flex; align-items: center; gap: 6px; font-weight: 600; font-size: 1em;">
                                ⏳ Reporte enviado — esperando revisión del Administrador
                            </h4>
                            <p style="margin: 0 0 4px 0; font-size: 0.93em;">
                                <strong>Tu reporte:</strong>
                                {{ !empty($task->adoptionRequest) ? $task->adoptionRequest->reporte_voluntario : $task->Tar_comentario }}
                            </p>
                            @if($esAdopcion && isset($task->adoptionRequest->apto))
                                <p style="margin: 6px 0 0 0; font-size: 0.93em;">
                                    <strong>Evaluación:</strong>
                                    <span style="font-weight: 700; color: {{ $task->adoptionRequest->apto ? '#15803d' : '#b91c1c' }};">
                                        {{ $task->adoptionRequest->apto ? '✓ Apto para adopción' : '✕ No apto para adopción' }}
                                    </span>
                                </p>
                            @endif
                        </div>

                    @elseif($esAdopcion)
                        {{-- ===================== FORMULARIO de reporte de adopción ===================== --}}
                        <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST" class="task-form-box" onsubmit="return validarAptoSeleccionado({{ $task->Tar_id }})">
                            @csrf
                            <input type="hidden" name="adoption_report" value="1">
                            <input type="hidden" name="apto" id="apto-input-{{ $task->Tar_id }}" value="">
                            <label class="task-form-label">📋 Reporte de Visita de Adopción</label>
                            <textarea name="reporte" rows="4" class="task-form-textarea"
                                placeholder="Describe lo que observaste en el hogar del adoptante: condiciones del espacio, trato con animales, compromisos, etc."
                                required></textarea>
                            <div style="margin: 10px 0 14px 0; display: grid; gap: 12px;">
                                <p style="margin: 0; font-size: 0.95em; color: #475569; font-weight: 700;">Evaluación de adopción</p>
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    <button type="button" onclick="seleccionarApto(1, this, {{ $task->Tar_id }})" data-task-id="{{ $task->Tar_id }}" data-value="1" class="apto-button" style="flex:1; padding: 14px 18px; border: 2px solid #4CAF50; border-radius: 10px; background: white; color: #166534; font-weight: 700; text-align: center; cursor: pointer; min-width: 150px;">
                                        ✓ Apto para adopción
                                    </button>
                                    <button type="button" onclick="seleccionarApto(0, this, {{ $task->Tar_id }})" data-task-id="{{ $task->Tar_id }}" data-value="0" class="apto-button" style="flex:1; padding: 14px 18px; border: 2px solid #f44336; border-radius: 10px; background: white; color: #b91c1c; font-weight: 700; text-align: center; cursor: pointer; min-width: 150px;">
                                        ✕ No apto para adopción
                                    </button>
                                </div>
                            </div>
                            <p style="margin: 0 0 12px 0; color: #475569; font-size: 0.92em;">Selecciona si la solicitud es apta o no apta para adopción antes de enviar el reporte.</p>
                            <button class="task-btn btn-success">✓ Enviar Reporte de Adopción</button>
                        </form>
                        @if(!$adoptionRequestId)
                            <p style="margin: 10px 0 0 0; color: #b91c1c; font-size: 0.92em;">Nota: esta tarea aún no está vinculada a una solicitud de adopción con `soli_id`. El reporte se guardará como comentario de tarea.</p>
                        @endif

                    @else
                        {{-- ===================== FORMULARIO de tarea normal ===================== --}}
                        <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST" class="task-form-box">
                            @csrf
                            <label class="task-form-label">📤 Enviar Reporte al Administrador</label>
                            <p style="margin: 0 0 8px 0; font-size: 0.88em; color: #64748b;">
                                Describe lo que realizaste. El administrador revisará y aprobará la tarea.
                            </p>
                            <div style="display:flex; gap:10px; flex-direction: column;">
                                <textarea name="comentario" rows="3" class="task-form-textarea"
                                    placeholder="Escribe aquí tu reporte de actividad…"
                                    required>{{ $task->Tar_comentario }}</textarea>
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

<script>
    function seleccionarApto(valor, boton, tareaId) {
        var inputApto = document.getElementById('apto-input-' + tareaId);
        if (!inputApto) {
            return;
        }

        // Asegurar que el valor es "1" o "0"
        inputApto.value = String(valor);

        var botones = document.querySelectorAll('.apto-button[data-task-id="' + tareaId + '"]');
        botones.forEach(function(elemento) {
            elemento.classList.remove('apto-selected');
        });

        boton.classList.add('apto-selected');
    }

    function validarAptoSeleccionado(tareaId) {
        var inputApto = document.getElementById('apto-input-' + tareaId);
        if (!inputApto || inputApto.value === '' || (inputApto.value !== '1' && inputApto.value !== '0')) {
            alert('Por favor selecciona si la persona es apta o no apta para adopción antes de enviar el reporte.');
            return false;
        }
        return true;
    }
</script>

<style>
    .apto-selected {
        color: white !important;
    }
    .apto-button[data-value="1"].apto-selected {
        background-color: #16a34a !important;
        border-color: #15803d !important;
    }
    .apto-button[data-value="0"].apto-selected {
        background-color: #dc2626 !important;
        border-color: #b91c1c !important;
    }
</style>

@endsection