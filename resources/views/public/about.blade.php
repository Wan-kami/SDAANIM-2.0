@extends('layouts.adopter.app')

@section('title', 'Quiénes Somos | Esperanza Animal BQ')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<main class="quienes-somos">

    {{-- BANNER --}}
    <section class="banner-quienes">
        <h2>Quiénes Somos</h2>
        <p>Conoce nuestra misión, visión y valores como fundación dedicada al bienestar animal 🐾</p>
    </section>

    {{-- GRID: MISIÓN + VISIÓN en 2 columnas --}}
    <div class="quienes-grid">

        <section class="seccion">
            <h3>🐶 Nuestra Misión</h3>
            <p>Promover la adopción responsable de animales rescatados, ofreciendo un sistema digital que optimice la gestión del refugio, facilite el acceso a la información de los animales en espera y agilice el proceso de adopción. Buscamos mejorar la calidad de vida de los peluditos y fomentar hogares responsables que les brinden amor y cuidado.</p>
        </section>

        <section class="seccion">
            <h3>🌟 Nuestra Visión</h3>
            <p>Para el año 2040 seremos una plataforma líder en adopción responsable de animales en Colombia, reconocida por su innovación tecnológica y su impacto social, expandiendo nuestra solución a múltiples refugios y convirtiéndonos en un referente en la protección animal y el bienestar comunitario.</p>
        </section>

    </div>

    {{-- VALORES con definición --}}
    <section class="seccion valores">
        <h3>💡 Nuestros Valores</h3>
        <div class="valores-grid">

            <div class="valor-card">
                <span class="valor-titulo">🤝 Compromiso</span>
                <span class="valor-desc">Nos dedicamos con constancia al bienestar de cada animal, sin importar las dificultades del camino.</span>
            </div>

            <div class="valor-card">
                <span class="valor-titulo">🔍 Transparencia</span>
                <span class="valor-desc">Gestionamos cada proceso de adopción de forma abierta, clara y honesta para adoptantes y voluntarios.</span>
            </div>

            <div class="valor-card">
                <span class="valor-titulo">💻 Innovación</span>
                <span class="valor-desc">Usamos tecnología para transformar la forma en que los refugios operan y conectan con la comunidad.</span>
            </div>

            <div class="valor-card">
                <span class="valor-titulo">📋 Responsabilidad</span>
                <span class="valor-desc">Hacemos seguimiento a cada animal adoptado para asegurar que viva en un hogar digno y amoroso.</span>
            </div>


        </div>
    </section>

</main>
@endsection
