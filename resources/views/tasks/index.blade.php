@extends('layouts.app')

@section('panel-title', 'Mis Tareas')

@section('styles')
<style>
    .tasks-page-container {
        padding: 0;
    }
    .tasks-page-header {
        margin-bottom: 32px;
    }
    .tasks-page-header h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
    }
    .tasks-page-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }
    .task-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        border-left: 5px solid #3b82f6;
        transition: all 0.2s ease;
    }
    .task-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }
    .task-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px 0;
    }
    .task-desc {
        color: #64748b;
        font-size: 0.92rem;
        margin: 0 0 12px 0;
        line-height: 1.5;
    }
    .task-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 20px;
        font-size: 0.85rem;
        color: #64748b;
    }
    .task-meta strong {
        color: #475569;
    }
    .task-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 99px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .task-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }
    .task-btn {
        padding: 9px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .task-btn:hover {
        transform: translateY(-1px);
    }
    .btn-observation {
        background: #fef3c7;
        color: #92400e;
    }
    .btn-observation:hover {
        background: #fde68a;
    }
    .btn-process {
        background: #dbeafe;
        color: #1e40af;
    }
    .btn-process:hover {
        background: #bfdbfe;
    }
    .btn-success {
        background: #166534;
        color: white;
        box-shadow: 0 4px 10px rgba(22, 101, 52, 0.2);
    }
    .btn-success:hover {
        background: #15803d;
    }
    .btn-update {
        background: #f1f5f9;
        color: #475569;
    }
    .btn-update:hover {
        background: #e2e8f0;
    }
    .task-form-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px;
        margin-top: 20px;
        border: 1px solid #f1f5f9;
    }
    .task-form-label {
        display: block;
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }
    .task-form-textarea {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: #ffffff;
        font-size: 0.92rem;
        color: #1e293b;
        resize: vertical;
        transition: all 0.2s ease;
        font-family: inherit;
        box-sizing: border-box;
    }
    .task-form-textarea:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
    }
    .adoption-info-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 16px;
        padding: 24px;
        margin-top: 20px;
    }
    .adoption-info-title {
        color: #166534;
        margin: 0 0 16px 0;
        font-size: 1rem;
        font-weight: 700;
    }
    .adoption-info-box p {
        margin: 6px 0;
        font-size: 0.9rem;
        color: #475569;
    }
    .task-empty {
        text-align: center;
        padding: 60px 20px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    .task-empty h3 {
        color: #64748b;
        margin: 16px 0 8px;
    }
    .task-empty p {
        color: #94a3b8;
        margin: 0 0 20px;
    }
    .alert-success-custom {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-weight: 600;
    }
    .apto-button {
        flex: 1;
        padding: 14px 18px;
        border-radius: 12px;
        font-weight: 700;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 150px;
    }
    .apto-button:hover {
        transform: translateY(-1px);
    }
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
    @media (max-width: 768px) {
        .tasks-page-container { padding: 20px 16px; }
        .task-header { flex-direction: column; }
        .task-card { padding: 20px; }
    }
</style>
@endsection

@section('content')
<div class="premium-dashboard-container">
    @include(Auth::user()->role == 'Veterinario' ? 'partials.vet_sidebar' : 'partials.volunteer_sidebar')

    <main class="dashboard-main-panel">
        <div class="tasks-page-container">
            <div class="tasks-page-header">
                <h1>Mis Tareas Asignadas</h1>
                <p>Lista de actividades pendientes para el refugio.</p>
            </div>

            @if(session('success'))
                <div class="alert-success-custom">{{ session('success') }}</div>
            @endif

            <div>
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
    </main>
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

@endsection