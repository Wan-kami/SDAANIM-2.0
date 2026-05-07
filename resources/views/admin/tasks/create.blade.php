@extends('layouts.app')

@section('content')
<div class="create-task-container">
    <!-- Header Section -->
    <div class="create-header">
        <div class="header-content">
            <h1>➕ Nueva Tarea</h1>
            <p class="subtitle">Asigna tareas a voluntarios y veterinarios</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.tasks.store') }}" method="POST" class="task-form">
            @csrf

            <!-- Row 1: Assign and Title -->
            <div class="form-row">
                <div class="form-group">
                    <label for="Usu_documento" class="form-label">
                        <span class="icon">👤</span>
                        Asignar a
                    </label>
                    <select name="Usu_documento" id="Usu_documento" class="form-input form-select" required>
                        <option value="">-- Seleccionar usuario --</option>
                        <optgroup label="👥 Voluntarios">
                            @foreach($users->where('role', 'Voluntario') as $user)
                            <option value="{{ $user->Usu_documento }}" data-role="Voluntario">{{ $user->name }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="⚕️ Veterinarios">
                            @foreach($users->where('role', 'Veterinario') as $user)
                            <option value="{{ $user->Usu_documento }}" data-role="Veterinario">{{ $user->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Tar_titulo" class="form-label">
                        <span class="icon">📝</span>
                        Título
                    </label>
                    <input type="text" name="Tar_titulo" id="Tar_titulo" class="form-input" required placeholder="Ej. Seguimiento de adopción">
                </div>
            </div>

            <!-- Role Specific Fields (Dynamic) -->
            <div id="role-specific-container" style="display: none;">
                <!-- Animal Selection (Common for reviews) -->
                <div class="form-group mb-4">
                    <label for="Anim_id" class="form-label">
                        <span class="icon">🐾</span>
                        Animal para revisión
                    </label>
                    <select name="Anim_id" id="Anim_id" class="form-input form-select">
                        <option value="">-- Seleccionar animal --</option>
                        @foreach($animals as $animal)
                        <option value="{{ $animal->Anim_id }}" data-name="{{ $animal->Anim_nombre }}">{{ $animal->Anim_nombre }} ({{ $animal->Anim_raza }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Vet Section -->
                <div id="vet-fields" class="role-fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tipo_atencion" class="form-label">
                                <span class="icon">🩺</span>
                                Tipo de Atención
                            </label>
                            <select name="tipo_atencion" id="tipo_atencion" class="form-input form-select">
                                <option value="">-- Seleccionar tipo --</option>
                                <option value="Consulta General">Consulta General</option>
                                <option value="Vacunación">Vacunación</option>
                                <option value="Desparasitación">Desparasitación</option>
                                <option value="Cirugía">Cirugía</option>
                                <option value="Revisión de Herida">Revisión de Herida</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prioridad" class="form-label">
                                <span class="icon">⚡</span>
                                Prioridad
                            </label>
                            <select name="prioridad" id="prioridad" class="form-input form-select">
                                <option value="Normal">Normal</option>
                                <option value="Alta">Alta</option>
                                <option value="Urgente">Urgente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Volunteer Section -->
                <div id="volunteer-fields" class="role-fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="actividad_voluntario" class="form-label">
                                <span class="icon">🎾</span>
                                Actividad
                            </label>
                            <select name="actividad_voluntario" id="actividad_voluntario" class="form-input form-select">
                                <option value="">-- Seleccionar actividad --</option>
                                <option value="Paseo">Paseo</option>
                                <option value="Baño y Peluquería">Baño y Peluquería</option>
                                <option value="Limpieza de Hábitat">Limpieza de Hábitat</option>
                                <option value="Alimentación">Alimentación</option>
                                <option value="Socialización">Socialización</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sector" class="form-label">
                                <span class="icon">🏢</span>
                                Sector/Área
                            </label>
                            <input type="text" name="sector" id="sector" class="form-input" placeholder="Ej. Patio A, Caniles 1-5">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Description -->
            <div class="form-group">
                <label for="Tar_descripcion" class="form-label">
                    <span class="icon">📄</span>
                    Descripción
                </label>
                <p class="field-description">Proporciona detalles sobre qué debe hacer el usuario</p>
                <textarea name="Tar_descripcion" id="Tar_descripcion" class="form-textarea" rows="5" required placeholder="Descripción detallada de la tarea..."></textarea>
            </div>

            <!-- Row 3: Location and Dates -->
            <div class="form-row">
                <div class="form-group">
                    <label for="Tar_base" class="form-label">
                        <span class="icon">📍</span>
                        Ubicación
                    </label>
                    <input type="text" name="Tar_base" id="Tar_base" class="form-input" value="Centro Principal" placeholder="Ubicación o base">
                </div>

                <div class="form-group">
                    <label for="Tar_fecha_asignacion" class="form-label">
                        <span class="icon">📅</span>
                        Fecha de Asignación
                    </label>
                    <input type="date" name="Tar_fecha_asignacion" id="Tar_fecha_asignacion" class="form-input" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <!-- Row 4: Due Date and Time -->
            <div class="form-row">
                <div class="form-group">
                    <label for="Tar_fecha_limite" class="form-label">
                        <span class="icon">⏰</span>
                        Fecha Límite *
                    </label>
                    <input type="date" name="Tar_fecha_limite" id="Tar_fecha_limite" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="Tar_hora" class="form-label">
                        <span class="icon">🕐</span>
                        Hora
                    </label>
                    <input type="time" name="Tar_hora" id="Tar_hora" class="form-input">
                </div>
            </div>



            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span class="btn-icon">✓</span>
                    Crear Tarea
                </button>
                <a href="{{ route('admin.tasks') }}" class="btn btn-secondary">
                    <span class="btn-icon">←</span>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-icon">ℹ️</div>
        <div class="info-content">
            <strong>Consejos:</strong>
            <ul>
                <li>Sé específico en el título y descripción</li>
                <li>Asegúrate de que la fecha límite sea realista</li>
                <li>Vincula la tarea a una adopción si es relevante</li>
            </ul>
        </div>
    </div>
</div>

<style>
    .create-task-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header Styles */
    .create-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .header-content h1 {
        font-size: 2rem;
        color: #4CAF50;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .task-form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    /* Form Groups */
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

    .form-row .form-group {
        margin: 0;
    }

    .form-label {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .icon {
        font-size: 1.3rem;
    }

    .field-description {
        font-size: 0.85rem;
        color: #999;
        margin: 0;
        font-style: italic;
    }

    /* Form Inputs */
    .form-input {
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 0.95rem;
        color: #333;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background: #f8fdf7;
    }

    .form-input::placeholder {
        color: #bbb;
    }

    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.2em;
        padding-right: 2.5rem;
    }

    /* Textarea */
    .form-textarea {
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 0.95rem;
        color: #333;
        resize: vertical;
        transition: all 0.3s ease;
        min-height: 120px;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background: #f8fdf7;
    }

    .form-textarea::placeholder {
        color: #bbb;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 2rem;
        border-top: 2px solid #f0f0f0;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        flex: 1;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(76, 175, 80, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: #f5f5f5;
        color: #666;
        border: 2px solid #e0e0e0;
    }

    .btn-secondary:hover {
        background: #ede7f6;
        color: #4CAF50;
        border-color: #4CAF50;
        transform: translateY(-2px);
    }

    .btn-icon {
        font-size: 1.1rem;
    }

    /* Info Box */
    .info-box {
        background: #fff3e0;
        border-left: 5px solid #ff9800;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        gap: 1rem;
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.15);
    }

    .info-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .info-content strong {
        color: #e65100;
        display: block;
        margin-bottom: 0.5rem;
    }

    .info-content ul {
        color: #e65100;
        margin: 0;
        padding-left: 1.5rem;
        font-size: 0.9rem;
    }

    .info-content li {
        margin-bottom: 0.3rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .create-task-container {
            padding: 1rem;
        }

        .header-content h1 {
            font-size: 1.5rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .info-box {
            flex-direction: column;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('Usu_documento');
        const roleContainer = document.getElementById('role-specific-container');
        const vetFields = document.getElementById('vet-fields');
        const volFields = document.getElementById('volunteer-fields');
        const titleInput = document.getElementById('Tar_titulo');
        const animalSelect = document.getElementById('Anim_id');
        const vetTypeSelect = document.getElementById('tipo_atencion');
        const volActSelect = document.getElementById('actividad_voluntario');

        function updateFields() {
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            const role = selectedOption.getAttribute('data-role');

            if (role === 'Veterinario') {
                roleContainer.style.display = 'block';
                vetFields.style.display = 'block';
                volFields.style.display = 'none';
            } else if (role === 'Voluntario') {
                roleContainer.style.display = 'block';
                vetFields.style.display = 'none';
                volFields.style.display = 'block';
            } else {
                roleContainer.style.display = 'none';
                vetFields.style.display = 'none';
                volFields.style.display = 'none';
            }
        }

        function autoGenerateTitle() {
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            const role = selectedOption.getAttribute('data-role');
            const animalName = animalSelect.options[animalSelect.selectedIndex].getAttribute('data-name') || '';
            
            let activity = '';
            if (role === 'Veterinario') {
                activity = vetTypeSelect.value;
            } else if (role === 'Voluntario') {
                activity = volActSelect.value;
            }

            if (activity && animalName) {
                titleInput.value = `${activity}: ${animalName}`;
            } else if (activity) {
                titleInput.value = activity;
            } else if (animalName) {
                titleInput.value = `Revisión: ${animalName}`;
            }
        }

        userSelect.addEventListener('change', function() {
            updateFields();
            autoGenerateTitle();
        });

        animalSelect.addEventListener('change', autoGenerateTitle);
        vetTypeSelect.addEventListener('change', autoGenerateTitle);
        volActSelect.addEventListener('change', autoGenerateTitle);

        // Run on load in case of validation errors returning data
        updateFields();
    });
</script>
@endsection
