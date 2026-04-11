@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.adoptions') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Asignar Voluntario</h2>

    <div class="contenedor">
        <form action="{{ route('admin.adoptions.assign.store') }}" method="POST">
            @csrf
            <input type="hidden" name="Soli_id" value="{{ $adoptionId }}">

            <label for="vol_id">Seleccionar voluntario:</label>
            <select name="vol_id" id="vol_id" required>
                <option value="">Seleccione...</option>
                @forelse($volunteers as $vol)
                <option value="{{ $vol->Usu_documento }}">{{ $vol->name }}</option>
                @empty
                <option disabled>No hay voluntarios registrados</option>
                @endforelse
            </select>

            <button type="submit">Asignar</button>
        </form>
    </div>
</main>
@endsection
