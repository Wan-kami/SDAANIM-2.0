@extends('layouts.volunteer.app')

@section('title', 'Panel Voluntario | SDAANIM')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/volunteer/dashboard.css') }}">
@endsection

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #007acc; font-family: 'Pacifico', cursive;">Bienvenido, {{ Auth::user()->name }} 🐾</h1>
    <p>Tu labor como voluntario es fundamental para nosotros.</p>
</div>

<section class="admin-sections">
    <div class="admin-card">
        <div class="icon">📝</div>
        <h3>Tareas Asignadas</h3>
        <p>Revisa tus tareas pendientes y regístralas como completadas.</p>
        <a href="{{ route('volunteer.tasks') }}">Mis Tareas</a>
    </div>
    <div class="admin-card">
        <div class="icon"></div>
        <h3>Notificaciones</h3>
        <p>Mantente informado sobre todas tus actividades y cambios asignados.</p>
        <a href="{{ route('notifications') }}">Ver Notificaciones</a>
    </div>
    <div class="admin-card">
        <div class="icon">📈</div>
        <h3>Mi Progreso</h3>
        <p>Consulta las actividades que has realizado recientemente.</p>
        <a href="{{ route('volunteer.progress') }}">Ver Mi Progreso</a>
    </div>
</section>
@endsection
