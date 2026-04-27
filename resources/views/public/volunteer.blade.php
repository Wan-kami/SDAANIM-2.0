@extends('layouts.adopter.app')

@section('title', 'Quiero ser Voluntario | Esperanza Animal BQ')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<div class="role-page">

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
    <div class="role-hero">
        <div>
            <h1>Conviértete en Voluntario</h1>
            <p>Ayuda con el cuidado, transporte, alimentación y bienestar de los animales. Tú puedes ser la diferencia para perros y gatos que necesitan compañía, amor y atención.</p>

            <div class="role-card" style="margin-top: 20px;">
                <h3>¿Qué hacemos juntos?</h3>
                <ul>
                    <li>Recogida de donaciones y entrega de alimentos.</li>
                    <li>Apoyo en jornadas de adopción y eventos.</li>
                    <li>Cuidado diario de peluditos en el refugio.</li>
                </ul>
            </div>

            {{-- BOTÓN QUE ABRE EL MODAL --}}
            <button class="btn-inscribirse vol" onclick="abrirFormModal('formModalVol')">
                🙋 Quiero ser voluntario
            </button>
        </div>
        <div class="hero-card">
            <img src="{{ asset('img/Volun.jpg') }}" alt="Voluntario" style="width: 100%; border-radius: 18px; object-fit: cover; height: 100%;">
        </div>
    </div>

    {{-- CARDS DE INFO --}}
    <div class="role-grid">
        <div class="role-card">
            <h3>Requisitos</h3>
            <ul>
                <li>Amar a los animales.</li>
                <li>Ser mayor de 16 años o venir acompañado de un adulto.</li>
                <li>Tener ganas de sumar y aprender.</li>
            </ul>
        </div>
        <div class="role-card">
            <h3>Beneficios</h3>
            <ul>
                <li>Formar parte de un equipo comprometido.</li>
                <li>Participar en actividades con mascotas.</li>
                <li>Recibir reconocimiento por tu tiempo y dedicación.</li>
            </ul>
        </div>
    </div>

</div>

{{-- ===== MODAL FORMULARIO VOLUNTARIO ===== --}}
<div id="formModalVol" class="form-modal-overlay" onclick="cerrarFormModalOutside(event, 'formModalVol')">
    <div class="form-modal-card vol">
        <button class="form-modal-close" onclick="cerrarFormModal('formModalVol')" title="Cerrar">✕</button>
        <h2>🙋 Inscripción como Voluntario</h2>

        <form action="{{ route('inscriptions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="ins_tipo_rol" value="voluntario">

            <div class="role-form" style="padding: 0; background: none; box-shadow: none;">

                <label for="vol_documento">Documento</label>
                <input type="text" id="vol_documento" name="ins_documento" value="{{ old('ins_documento') }}" required>

                <label for="vol_nombre">Nombre completo</label>
                <input type="text" id="vol_nombre" name="ins_nombre" value="{{ old('ins_nombre') }}" required>

                <label for="vol_email">Correo electrónico</label>
                <input type="email" id="vol_email" name="ins_email" value="{{ old('ins_email') }}" required>

                <label for="vol_telefono">Teléfono</label>
                <input type="text" id="vol_telefono" name="ins_telefono" value="{{ old('ins_telefono') }}">

                <label for="vol_direccion">Dirección</label>
                <input type="text" id="vol_direccion" name="ins_direccion" value="{{ old('ins_direccion') }}">

                <label for="vol_tipo_ayuda">¿En qué te gustaría ayudar?</label>
                <select id="vol_tipo_ayuda" name="ins_tipo_ayuda" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Ayuda en el refugio" {{ old('ins_tipo_ayuda') == 'Ayuda en el refugio' ? 'selected' : '' }}>Ayuda en el refugio</option>
                    <option value="Cuidado de los animales" {{ old('ins_tipo_ayuda') == 'Cuidado de los animales' ? 'selected' : '' }}>Cuidado de los animales</option>
                </select>

                <label for="vol_comentario">Contanos un poco sobre ti</label>
                <textarea id="vol_comentario" name="ins_comentario" placeholder="¿Tienes experiencia con animales? ¿También puedes apoyar con logística?">{{ old('ins_comentario') }}</textarea>

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
            abrirFormModal('formModalVol');
        });
    @endif
</script>

@endsection
