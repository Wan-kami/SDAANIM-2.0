@extends($layout)

@section('title', 'Mi Progreso | SDAANIM')

@section('content')
<div style="max-width: 1000px; margin: 30px auto; padding: 20px;">
    
    <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; background: #ffffff; color: #475569; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.95em; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.borderColor='#cbd5e1'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='#ffffff'; this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Volver al Panel
    </a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; color: #2e8b57; font-family: 'Pacifico', cursive;">Mi Impacto y Progreso 🏆</h1>
            <p style="color: #666;">Visualiza el avance de tus labores en el refugio.</p>
        </div>
        <a href="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.tasks' : 'volunteer.tasks') }}" style="background: #0ea5e9; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9em;">📋 Ir a Mis Tareas Pendientes</a>
    </div>

    {{-- TARJETAS DE RESUMEN --}}
    <div class="progress-summary-grid">
        <div class="progress-summary-card" style="border-bottom: 4px solid #0ea5e9;">
            <span style="font-size: 2em;">📅</span>
            <h3 style="margin: 10px 0 5px; color: #1e293b;">{{ $totalCount }}</h3>
            <p style="margin: 0; color: #64748b; font-size: 0.9em;">Tareas Totales</p>
        </div>
        <div class="progress-summary-card" style="border-bottom: 4px solid #f59e0b;">
            <span style="font-size: 2em;">⏳</span>
            <h3 style="margin: 10px 0 5px; color: #1e293b;">{{ $pendingCount }}</h3>
            <p style="margin: 0; color: #64748b; font-size: 0.9em;">En Curso</p>
        </div>
        <div class="progress-summary-card" style="border-bottom: 4px solid #10b981;">
            <span style="font-size: 2em;">✅</span>
            <h3 style="margin: 10px 0 5px; color: #1e293b;">{{ $completedCount }}</h3>
            <p style="margin: 0; color: #64748b; font-size: 0.9em;">Completadas</p>
        </div>
    </div>

    {{-- LISTADO DE PROGRESO VISUAL --}}
    <h2 style="color: #1e293b; border-left: 5px solid #2e8b57; padding-left: 15px; margin-bottom: 20px;">Seguimiento de Actividades</h2>
    
    <div style="display: grid; gap: 20px;">
        @forelse($allTasks as $task)
            @php
                $colors = $task->status_colors;
                $percent = $colors['progress'];
                $color = $colors['border'];
            @endphp
            <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0; color: #1e293b;">{{ $task->Tar_titulo }}</h3>
                        <small style="color: #64748b;">Asignada el: {{ $task->Tar_fecha_asignacion->format('d/m/Y') }}</small>
                    </div>
                    <span style="font-weight: bold; color: {{ $colors['text'] }}; background: {{ $colors['bg'] }}; padding: 5px 12px; border-radius: 10px; font-size: 0.85em;">{{ $task->Tar_estado }}</span>
                </div>

                {{-- BARRA DE PROGRESO --}}
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: {{ $percent }}%; background: {{ $color }};"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.8em; color: #94a3b8; font-weight: bold;">
                    <span>INICIO</span>
                    <span>{{ $percent }}%</span>
                    <span>FINAL</span>
                </div>

                @if($task->Tar_comentario)
                    <div style="margin-top: 15px; padding: 10px; background: #f8fafc; border-radius: 8px; border-left: 3px solid {{ $color }};">
                        <p style="margin: 0; font-size: 0.9em; color: #475569;"><strong>Mi Reporte:</strong> "{{ $task->Tar_comentario }}"</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="task-empty">
                <p>Aún no tienes actividades registradas para mostrar progreso 🐾</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
