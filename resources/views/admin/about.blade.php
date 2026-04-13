@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.dashboard') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Editar Página "Quiénes Somos"</h2>

    @if(session('success'))
    <p class="mensaje">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.about.update') }}">
        @csrf
        @method('PUT')

        <label>Misión:</label>
        <textarea name="mision">{{ $about->mision ?? old('mision') }}</textarea>

        <label>Visión:</label>
        <textarea name="vision">{{ $about->vision ?? old('vision') }}</textarea>

        <label>Valores (uno por línea):</label>
        <textarea name="valores">{{ is_array($about->valores ?? []) ? implode("\n", $about->valores) : ($about->valores ?? '') }}</textarea>

        <button type="submit">💾 Guardar Cambios</button>
        <a href="{{ route('admin.dashboard') }}" style="margin-left: 15px; text-decoration: none; color: #4caf50;">Regresar</a>
    </form>
</main>
@endsection
