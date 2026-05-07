@extends('layouts.app')

@section('content')
<div class="create-task-container">
    <!-- Header Section -->
    <div class="create-header">
        <div class="header-content">
            <h1>🐕 Tarea de Seguimiento</h1>
            <p class="subtitle">Asigna una tarea vinculada a una solicitud de adopción</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.tasks.store') }}" method="POST" class="task-form">
            @csrf

            <!-- Adoption Selection (MANDATORY) -->
            <div class="form-group mb-4">
                <label for="Soli_id" class="form-label">
                    <span class="icon">📄</span>
                    Seleccionar Solicitud de Adopción *
                </label>
                <select name="Soli_id" id="Soli_id" class="form-input form-select" required>
                    <option value="">-- Seleccionar solicitud --</option>
                    @foreach($adoptions as $adoption)
                    <option value="{{ $adoption->Soli_id }}" data-animal="{{ $adoption->animal->Anim_nombre ?? '' }}" data-user="{{ $adoption->user->name ?? '' }}">
                        #{{ $adoption->Soli_id }} - {{ $adoption->animal->Anim_nombre ?? 'Animal' }} ({{ $adoption->user->name ?? 'Usuario' }})
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Row 1: Assign and Title -->
            <div class="form-row">
                <div class="form-group">
                    <label for="Usu_documento" class="form-label">
                        <span class="icon">👤</span>
                        Asignar a
                    </label>
                    <select name="Usu_documento" id="Usu_documento" class="form-input form-select" required>
                        <option value="">-- Seleccionar voluntario --</option>
                        @foreach($users->where('role', 'Voluntario') as $user)
                        <option value="{{ $user->Usu_documento }}">{{ $user->name }}</option>
                        @endforeach
                        <optgroup label="⚕️ Veterinarios (Opcional)">
                            @foreach($users->where('role', 'Veterinario') as $user)
                            <option value="{{ $user->Usu_documento }}">{{ $user->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Tar_titulo" class="form-label">
                        <span class="icon">📝</span>
                        Título de la Tarea
                    </label>
                    <input type="text" name="Tar_titulo" id="Tar_titulo" class="form-input" required placeholder="Ej. Visita de seguimiento">
                </div>
            </div>

            <!-- Row 2: Description -->
            <div class="form-group">
                <label for="Tar_descripcion" class="form-label">
                    <span class="icon">📄</span>
                    Descripción del Seguimiento
                </label>
                <textarea name="Tar_descripcion" id="Tar_descripcion" class="form-textarea" rows="5" required placeholder="Instrucciones para el voluntario (ej. Verificar condiciones del hogar, entrevista familiar...)"></textarea>
            </div>

            <!-- Row 3: Dates -->
            <div class="form-row">
                <div class="form-group">
                    <label for="Tar_fecha_limite" class="form-label">
                        <span class="icon">⏰</span>
                        Fecha Límite para el Reporte *
                    </label>
                    <input type="date" name="Tar_fecha_limite" id="Tar_fecha_limite" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="Tar_hora" class="form-label">
                        <span class="icon">🕐</span>
                        Hora Sugerida
                    </label>
                    <input type="time" name="Tar_hora" id="Tar_hora" class="form-input">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span class="btn-icon">✓</span>
                    Crear Tarea de Adopción
                </button>
                <a href="{{ route('admin.tasks') }}" class="btn btn-secondary">
                    <span class="btn-icon">←</span>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .create-task-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .create-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .create-header h1 {
        font-size: 2rem;
        color: #4CAF50;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    .task-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-input {
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-select {
        cursor: pointer;
    }

    .form-textarea {
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 0.95rem;
        resize: vertical;
        min-height: 120px;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
    }

    .btn-primary {
        background: #4CAF50;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #45a049;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #f5f5f5;
        color: #666;
        border: 1px solid #ddd;
    }

    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const soliSelect = document.getElementById('Soli_id');
        const titleInput = document.getElementById('Tar_titulo');
        const descTextarea = document.getElementById('Tar_descripcion');

        soliSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            if (this.value) {
                const animal = option.dataset.animal;
                const user = option.dataset.user;
                titleInput.value = `Seguimiento de Adopción: ${animal}`;
                descTextarea.value = `Realizar seguimiento de la solicitud #${this.value} para la adopción de ${animal} por parte de ${user}. \n\nObjetivos:\n1. Entrevista con la familia\n2. Verificación de condiciones del hogar\n3. Evaluación de compatibilidad`;
            }
        });
    });
</script>
@endsection
