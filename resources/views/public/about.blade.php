@extends('layouts.adopter.app')

@section('title', 'Quiénes Somos | Esperanza Animal BQ')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

    <main class="quienes-somos">

        {{-- BANNER --}}
        <section class="banner-quienes">
            <div class="page-hero-badge">🐾 Fundación SDAANIM</div>
            <h2>Quiénes Somos</h2>
            <p>Conoce nuestra misión, visión y valores como fundación dedicada al bienestar animal 🐾</p>
            <div class="page-hero-actions">
                <a href="{{ route('adopta') }}" class="page-hero-btn">Adoptar ahora</a>
                <a href="{{ route('products.public') }}" class="page-hero-btn page-hero-btn-secondary">Explorar
                    productos</a>
            </div>
        </section>

        {{-- GRID: MISIÓN + VISIÓN en 2 columnas --}}
        <div class="quienes-grid">

            <section class="seccion">
                <h3>🐶 Nuestra Misión</h3>
                <p>{{ $about->mision ?? 'Nuestra misión se verá aquí una vez que la administre el equipo.' }}</p>
            </section>

            <section class="seccion">
                <h3>🌟 Nuestra Visión</h3>
                <p>{{ $about->vision ?? 'Nuestra visión se verá aquí una vez que la administre el equipo.' }}</p>
            </section>

        </div>

        {{-- VALORES con definición --}}
        <section class="seccion valores">
            <h3>💡 Nuestros Valores</h3>
            <div class="valores-grid">
                @php
                    $valores = $about->valores;
                    if (!is_array($valores)) {
                        $decoded = json_decode($valores, true);
                        $valores = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $about->valores ?? '');
                    }
                @endphp

                @forelse($valores as $valor)
                    @if(trim($valor) !== '')
                        <div class="valor-card">
                            <span class="valor-titulo">{{ trim($valor) }}</span>
                        </div>
                    @endif
                @empty
                    <div class="valor-card">
                        <span class="valor-titulo">🤝 Compromiso</span>
                    </div>
                    <div class="valor-card">
                        <span class="valor-titulo">🔍 Transparencia</span>
                    </div>
                    <div class="valor-card">
                        <span class="valor-titulo">💻 Innovación</span>
                    </div>
                    <div class="valor-card">
                        <span class="valor-titulo">📋 Responsabilidad</span>
                    </div>
                @endforelse
            </div>
        </section>

    </main>
@endsection