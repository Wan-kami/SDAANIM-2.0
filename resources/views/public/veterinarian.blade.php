@extends('layouts.adopter.app')

@section('title', 'Quiero ser Veterinario | Esperanza Animal BQ')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<div class="role-page">

    {{-- Alertas fuera del modal --}}
    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- HERO --}}
    <div class="role-hero vet">
        <div>
            <h1>Conviértete en Veterinario</h1>
            <p>Si eres profesional en medicina veterinaria y querés ayudar a nuestros peluditos del refugio, tu experiencia es clave para su bienestar y recuperación.</p>

            <div class="role-card vet" style="margin-top: 20px;">
                <h3>Tu apoyo puede ser:</h3>
                <ul>
                    <li>Atención médica en el refugio.</li>
                    <li>Seguimiento de animales en adopción.</li>
                    <li>Asesoría en campañas de salud y esterilización.</li>
                </ul>
            </div>

            {{-- BOTÓN QUE ABRE EL MODAL --}}
            <button class="btn-inscribirse vet" onclick="abrirFormModal('formModalVet')">
                📋 Quiero inscribirme
            </button>
        </div>
        <div class="hero-card">
            <img src="{{ asset('img/Veterinarios.jpeg') }}" alt="Veterinario" style="width: 100%; border-radius: 18px; object-fit: cover; height: 100%;">
        </div>
    </div>

    {{-- CARDS DE INFO --}}
    <div class="role-grid">
        <div class="role-card vet">
            <h3>Requisitos</h3>
            <ul>
                <li>Título profesional veterinario.</li>
                <li>Experiencia en atención de perros y gatos.</li>
                <li>Compromiso con el cuidado y la salud animal.</li>
            </ul>
        </div>
        <div class="role-card vet">
            <h3>Qué buscamos</h3>
            <ul>
                <li>Disponibilidad para consultas y procedimientos.</li>
                <li>Responsabilidad en seguimiento de tratamientos.</li>
                <li>Vocación por el trabajo en equipo.</li>
            </ul>
        </div>
    </div>

</div>

{{-- ===== MODAL FORMULARIO VETERINARIO ===== --}}
<div id="formModalVet" class="form-modal-overlay" onclick="cerrarFormModalOutside(event, 'formModalVet')">
    <div class="form-modal-card vet">
        <button class="form-modal-close" onclick="cerrarFormModal('formModalVet')" title="Cerrar">✕</button>
        <h2>📋 Inscripción como Veterinario</h2>

        <form action="{{ route('inscriptions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="ins_tipo_rol" value="veterinario">

            <div class="role-form vet" style="padding: 0; background: none; box-shadow: none;">

                <label for="vet_documento">Documento</label>
                <input type="text" id="vet_documento" name="ins_documento" value="{{ old('ins_documento') }}" required>

                <label for="vet_nombre">Nombre completo</label>
                <input type="text" id="vet_nombre" name="ins_nombre" value="{{ old('ins_nombre') }}" required>

                <label for="vet_email">Correo electrónico</label>
                <input type="email" id="vet_email" name="ins_email" value="{{ old('ins_email') }}" required>

                <label for="vet_telefono">Teléfono</label>
                <input type="text" id="vet_telefono" name="ins_telefono" value="{{ old('ins_telefono') }}">

                <label for="vet_direccion">Dirección</label>
                <input type="text" id="vet_direccion" name="ins_direccion" value="{{ old('ins_direccion') }}">

                <label for="vet_especialidad">Especialidad</label>
                <input type="text" id="vet_especialidad" name="ins_especialidad" value="{{ old('ins_especialidad') }}" placeholder="Ej: Medicina interna, cirugía, anestesia">

                <label for="vet_experiencia">Años de experiencia</label>
                <input type="number" id="vet_experiencia" name="ins_experiencia_anos" value="{{ old('ins_experiencia_anos') }}" min="0">

                <label for="vet_certificado">Certificado o título</label>
                <input type="text" id="vet_certificado" name="ins_certificado" value="{{ old('ins_certificado') }}" placeholder="Nombre de la institución o título">

                <label for="vet_tipo_ayuda">Tipo de apoyo que puedes brindar</label>
                <select id="vet_tipo_ayuda" name="ins_tipo_ayuda" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Consultas" {{ old('ins_tipo_ayuda') == 'Consultas' ? 'selected' : '' }}>Consultas</option>
                    <option value="Cirugías" {{ old('ins_tipo_ayuda') == 'Cirugías' ? 'selected' : '' }}>Cirugías</option>
                    <option value="Urgencias" {{ old('ins_tipo_ayuda') == 'Urgencias' ? 'selected' : '' }}>Urgencias</option>
                    <option value="Campañas de salud" {{ old('ins_tipo_ayuda') == 'Campañas de salud' ? 'selected' : '' }}>Campañas de salud</option>
                </select>

                <label for="vet_comentario">Háblanos de tu experiencia</label>
                <textarea id="vet_comentario" name="ins_comentario" placeholder="Describe tu experiencia clínica, voluntariados previos o disponibilidad.">{{ old('ins_comentario') }}</textarea>

                <button type="submit" style="margin-top: 8px;">Enviar inscripción</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirFormModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function cerrarFormModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function cerrarFormModalOutside(event, id) {
        if (event.target === document.getElementById(id)) {
            cerrarFormModal(id);
        }
    }

    // Si hay errores de validación, abrir el modal automáticamente al cargar
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            abrirFormModal('formModalVet');
        });
    @endif
</script>

@endsection
