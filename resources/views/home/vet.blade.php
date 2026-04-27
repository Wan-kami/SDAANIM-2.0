@extends('layouts.vet.app')

@section('title', 'Panel Veterinario')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/vet/dashboard.css') }}">
@endsection

@section('content')
<div style="text-align: center; margin-bottom: 40px;">
    <h1 style="color: #1C9F96; font-family: 'Pacifico', cursive; font-size: 2.5em;">Bienvenido, Dr. {{ Auth::user()->name }} 🐾</h1>
    <p style="color: #666;">Gestiona la salud y bienestar de nuestros rescatados hoy.</p>
</div>

<section class="admin-sections">
    <div class="admin-card">
        <div class="icon">📋</div>
        <h3>Historiales Médicos</h3>
        <p>Accede a la base de datos completa de historiales clínicos y registros de salud.</p>
        <a href="{{ route('vet.animals') }}">Gestionar Historiales</a>
    </div>
    <div class="admin-card">
        <div class="icon">💉</div>
        <h3>Mi Disponibilidad</h3>
        <p>Registra y gestiona tu horario de atención y disponibilidad médica.</p>
        <a href="{{ route('vet.availability') }}">Gestionar Horario</a>
    </div>
    <div class="admin-card">
        <div class="icon">📝</div>
        <h3>Mis Tareas</h3>
        <p>Revisa las tareas asignadas por el administrador y regístralas como completadas.</p>
        <a href="{{ route('vet.tasks') }}">Ver Tareas</a>
    </div>
    <div class="admin-card">
        <div class="icon">🔔</div>
        <h3>Notificaciones</h3>
        <p>Mantente informado sobre todas tus actividades y cambios asignados.</p>
        <a href="{{ route('notifications') }}">Ver Notificaciones</a>
    </div>
    <div class="admin-card" style="border-top: 5px solid #ffa500;">
        <div class="icon">📈</div>
        <h3>Mi Progreso</h3>
        <p>Consulta el historial y avance visual de tus labores clínicas.</p>
        <a href="{{ route('vet.progress') }}" style="background: #ffa500; box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);">Ver Mi Progreso</a>
    </div>
</section>
@endsection
