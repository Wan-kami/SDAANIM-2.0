@extends('layouts.app')

@section('content')
<main class="perfil-container">
    <div class="perfil-card">
        <h1>Mi Perfil</h1>

        <div class="perfil-header">
            <img src="{{ asset('img/usuario.png') }}" alt="Foto de perfil" class="perfil-foto" onclick="abrirModalFoto(this)">
            <div>
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
                <a href="{{ route('profile.edit') }}" class="editar-link">✏️ Editar perfil</a>
            </div>
        </div>

        <!-- Modal para foto de perfil -->
        <div id="modalFoto" class="modal-foto" onclick="cerrarModalFoto(event)">
            <div class="modal-foto-contenido" onclick="event.stopPropagation()">
                <img id="modalFotoImg" src="{{ asset('img/usuario.png') }}" alt="Foto de perfil ampliada">
                <button class="cerrar-modal-foto" onclick="cerrarModalFoto()">&times;</button>
            </div>
        </div>

        <div class="perfil-opciones">
            <div class="opcion">
                <span>📞 Teléfono:</span>
                <p>{{ Auth::user()->Usu_telefono ?? 'No registrado' }}</p>
            </div>
            <div class="opcion">
                <span>📍 Dirección:</span>
                <p>{{ Auth::user()->Usu_direccion ?? 'No registrada' }}</p>
            </div>
            <div class="opcion">
                <span>👤 Rol:</span>
                <p>{{ Auth::user()->role }}</p>
            </div>

            <div class="opcion-btns">
                <button class="btn-cambiar" onclick="window.location.href='{{ route('profile.password') }}'">Cambiar Contraseña</button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-cerrar">Cerrar Sesión</button>
                </form>
                <button class="btn-eliminar" onclick="confirmarDesactivacion()">🚫 Desactivar Cuenta</button>
                <button class="btn-primary" onclick="window.location.href='{{ route('dashboard') }}'">Volver</button>
            </div>
            <br><br>

            <div class="perfil-politicas">
                <a href="#">Política de Privacidad</a> ·
                <a href="#">Condiciones del Servicio</a>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarDesactivacion() {
        Swal.fire({
            title: '¿Seguro que quieres desactivar tu cuenta?',
            text: "Podrás activarla nuevamente contactando soporte.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('profile.deactivate') }}";
            }
        });
    }
</script>
@endpush
