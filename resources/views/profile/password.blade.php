@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>Cambiar Contraseña</h2>
    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf
        @method('PUT')

        <input type="password" name="current_password" placeholder="Contraseña actual" required>

        <input type="password" name="password" placeholder="Nueva contraseña" required>

        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

        <button type="submit" name="cambiar">Actualizar</button>
    </form>

    <a href="{{ route('profile.show') }}">Volver al perfil</a>
</div>
@endsection
