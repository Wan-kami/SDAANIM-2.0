@extends('layouts.app')

@section('content')
<main>
    <a href="{{ route('admin.adoptions') }}" class="fancy-btn"><span>← Volver</span></a>

    <h2>Registrar Seguimiento - Solicitud #{{ $adoption->Soli_id }}</h2>

    <div class="admin-form" style="max-width: 600px;">
        <form action="{{ route('admin.adoptions.followup.store', $adoption->Soli_id) }}" method="POST">
            @csrf

            <label for="Segui_tipo">Tipo de Seguimiento:</label>
            <select name="Segui_tipo" id="Segui_tipo" required>
                <option value="">Seleccionar</option>
                <option value="Entrevista">Entrevista</option>
                <option value="Visita">Visita</option>
                <option value="Pos_visita">Pos-visita</option>
            </select>

            <label for="Segui_estado">Estado:</label>
            <select name="Segui_estado" id="Segui_estado" required>
                <option value="Pendiente">Pendiente</option>
                <option value="En proceso">En proceso</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Rechazada">Rechazada</option>
            </select>

            <label for="Segui_fecha">Fecha de Seguimiento:</label>
            <input type="date" name="Segui_fecha" id="Segui_fecha">

            <label for="Segui_descripcion">Descripción / Informe:</label>
            <textarea name="Segui_descripcion" id="Segui_descripcion" rows="5" placeholder="Ingrese los detalles del seguimiento..."></textarea>

            <button type="submit">Guardar Seguimiento</button>
        </form>
    </div>
</main>
@endsection
