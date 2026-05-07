@extends('layouts.app')

@section('content')
<main class="perfil-container">
    <div class="perfil-card">
        <h1>Editar Perfil</h1>

        <div class="perfil-foto-editar">
            <img src="{{ asset('img/usuario.png') }}" alt="Foto de perfil" class="perfil-foto" onclick="abrirModalFoto(this)">
            <label for="foto" class="btn-subir">Cambiar foto</label>
            <input type="file" id="foto" hidden>
        </div>

        <!-- Modal para foto de perfil -->
        <div id="modalFoto" class="modal-foto" onclick="cerrarModalFoto(event)">
            <div class="modal-foto-contenido" onclick="event.stopPropagation()">
                <img id="modalFotoImg" src="{{ asset('img/usuario.png') }}" alt="Foto de perfil ampliada">
                <button class="cerrar-modal-foto" onclick="cerrarModalFoto()">&times;</button>
            </div>
        </div>

        <form class="form-perfil" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>

            <label for="Usu_telefono">Teléfono:</label>
            <input type="text" id="Usu_telefono" name="Usu_telefono" value="{{ Auth::user()->Usu_telefono ?? '' }}">

            <label for="Usu_direccion">Ubicación</label>
            <input type="text" id="Usu_direccion" name="Usu_direccion" value="{{ Auth::user()->Usu_direccion ?? '' }}">

            <div class="acciones-form">
                <button type="submit" class="btn-guardar">💾 Guardar cambios</button>
                <button type="button" class="btn-cancelar" onclick="window.location.href='{{ route('profile.show') }}'">❌ Cancelar</button>
            </div>
        </form>
    </div>
</main>
@endsection
