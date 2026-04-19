@extends('layouts.app')

@section('content')
<div class="about-page-container">
    <!-- Header Section -->
    <div class="about-header">

            <h1>Editar Página "Quiénes Somos"</h1>
            <p class="subtitle">Actualiza la misión, visión y valores de tu fundación</p>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">✅</div>
        <div class="alert-content">
            <strong>¡Éxito!</strong>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Main Form Card -->
    <div class="form-card">
        <form method="POST" action="{{ route('admin.about.update') }}" class="about-form">
            @csrf
            @method('PUT')

            <!-- Misión Field -->
            <div class="form-group">
                <label for="mision" class="form-label">
                    <span class="icon">🐶</span>
                    Misión
                </label>
                <p class="field-description">La razón principal de existencia de tu fundación</p>
                <textarea 
                    id="mision"
                    name="mision" 
                    class="form-textarea"
                    placeholder="Describe la misión de tu fundación..."
                    rows="5"
                >{{ $about->mision ?? old('mision') }}</textarea>
                <span class="char-count"><span id="mision-count">0</span>/500 caracteres</span>
            </div>

            <!-- Visión Field -->
            <div class="form-group">
                <label for="vision" class="form-label">
                    <span class="icon">🌟</span>
                    Visión
                </label>
                <p class="field-description">Dónde quieres que esté tu fundación en el futuro</p>
                <textarea 
                    id="vision"
                    name="vision" 
                    class="form-textarea"
                    placeholder="Describe la visión de tu fundación..."
                    rows="5"
                >{{ $about->vision ?? old('vision') }}</textarea>
                <span class="char-count"><span id="vision-count">0</span>/500 caracteres</span>
            </div>

            <!-- Valores Field -->
            <div class="form-group">
                <label for="valores" class="form-label">
                    <span class="icon">💡</span>
                    Valores
                </label>
                <p class="field-description">Principios fundamentales (escribe uno por línea)</p>
                <textarea 
                    id="valores"
                    name="valores" 
                    class="form-textarea"
                    placeholder="Ejemplo:&#10;Compasión&#10;Transparencia&#10;Responsabilidad"
                    rows="6"
                >{{ is_array($about->valores ?? []) ? implode("\n", $about->valores) : ($about->valores ?? '') }}</textarea>
                <span class="char-count"><span id="valores-count">0</span>/500 caracteres</span>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span class="btn-icon">💾</span>
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <span class="btn-icon">← </span>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-icon">ℹ️</div>
        <div class="info-content">
            <strong>Consejo:</strong>
            <p>Mantén tu contenido claro y conciso. Los visitantes leerán esta información en la página "Quiénes Somos" de tu sitio.</p>
        </div>
    </div>
</div>

<style>
    .about-page-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 1rem;
        background: transparent;
    }

    /* Header Styles */
    .about-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .header-content h1 {
        font-size: 2rem;
        color: #009688;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    /* Success Alert */
    .alert {
        margin-bottom: 2rem;
        padding: 1.2rem;
        border-radius: 12px;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        animation: slideInDown 0.4s ease;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #e8f5e9;
        border-left: 5px solid #4caf50;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.15);
    }

    .alert-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .alert-content strong {
        color: #2e7d32;
        display: block;
        margin-bottom: 0.3rem;
    }

    .alert-content p {
        color: #558b2f;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .about-form {
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

    .form-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .icon {
        font-size: 1.5rem;
    }

    .field-description {
        font-size: 0.9rem;
        color: #999;
        margin: 0;
        font-style: italic;
    }

    .form-textarea {
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1rem;
        color: #333;
        resize: vertical;
        transition: all 0.3s ease;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #009688;
        box-shadow: 0 0 0 3px rgba(0, 150, 136, 0.1);
        background: #f0fffe;
    }

    .form-textarea::placeholder {
        color: #bbb;
    }

    .char-count {
        font-size: 0.85rem;
        color: #999;
        text-align: right;
        margin-top: 0.3rem;
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
        gap: 0.5rem;
        text-decoration: none;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #009688, #00796b);
        color: white;
        flex: 1;
        box-shadow: 0 4px 15px rgba(0, 150, 136, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 150, 136, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: #f5f5f5;
        color: #666;
        flex: 1;
        border: 2px solid #e0e0e0;
    }

    .btn-secondary:hover {
        background: #ede7f6;
        color: #009688;
        border-color: #009688;
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
        margin-bottom: 0.3rem;
    }

    .info-content p {
        color: #e65100;
        margin: 0;
        font-size: 0.95rem;
        opacity: 0.9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .about-page-container {
            padding: 1rem;
        }

        .header-content h1 {
            font-size: 1.8rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<script>
    // Character counter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.form-textarea');
        
        textareas.forEach(textarea => {
            const id = textarea.id;
            const countElement = document.getElementById(id + '-count');
            
            if (countElement) {
                // Update on input
                textarea.addEventListener('input', function() {
                    countElement.textContent = this.value.length;
                });
                
                // Initialize count
                countElement.textContent = textarea.value.length;
            }
        });
    });
</script>
@endsection
