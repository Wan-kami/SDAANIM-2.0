@extends('layouts.adopter.app')

@section('title', 'Quiénes Somos | Esperanza Animal BQ')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<main class="quienes-somos">
    <section class="banner-quienes">
        <h2>Quiénes Somos</h2>
        <p>Conoce nuestra misión, visión y valores como fundación dedicada al bienestar animal 🐾</p>
    </section>

    <section class="seccion">
        <h3>🐶 Nuestra Misión</h3>
        <p>{{ $about->mision ?? 'Nuestra misión es fomentar la adopción responsable de animales rescatados, ofreciendo un sistema digital que optimice la gestión del refugio.' }}</p>
    </section>

    <section class="seccion">
        <h3>🌟 Nuestra Visión</h3>
        <p>{{ $about->vision ?? 'Nuestra visión es ser la plataforma líder en adopción responsable de animales en Colombia.' }}</p>
    </section>

    <section class="seccion valores">
        <h3>💡 Nuestros Valores</h3>
        <ul>
            @if(isset($about->valores) && is_array($about->valores))
                @foreach($about->valores as $valor)
                    <li>{{ $valor }}</li>
                @endforeach
            @else
                <li>Compromiso</li>
                <li>Transparencia</li>
                <li>Innovación tecnológica</li>
                <li>Responsabilidad</li>
                <li>Empatía</li>
            @endif
        </ul>
    </section>
</main>
@endsection
