@extends('layouts.adopter.app')

@section('title', 'SDAANIM | Adopción de Mascotas')

@section('content')

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Banner -->
    <div class="banner">
        <h2>¡Encuentra a tu nuevo mejor amigo!</h2>
        <p>Todos los animales de la calle necesitan nuestra protección.
            <br>¡Ayúdanos hoy!
        </p>
    </div>

        <!-- Recién llegados -->
<div class="section-header">
    <h3>Recién llegados</h3>
    <a href="{{ route('adopta') }}">Ver más</a>
</div>

<br>

<!-- Carrusel -->
<div class="swiper mySwiper">
    <div class="swiper-wrapper">

        @forelse($animals ?? [] as $animal)
        <div class="swiper-slide">
            <div class="card">
                <a href="javascript:void(0);" 
                    onclick="abrirModal(
                        '{{ $animal->Anim_nombre }}',
                        '{{ $animal->Anim_edad }}',
                        '{{ $animal->Anim_raza }}',
                        '{{ $animal->Anim_historia ?? 'Sin historia disponible' }}',
                        '{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}'
                    )">
                    <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" alt="{{ $animal->Anim_nombre }}">
                    <p>{{ $animal->Anim_nombre }} - {{ $animal->Anim_edad }}</p>
                </a>
            </div>
        </div>
        @empty
        <div class="swiper-slide">
            <div class="card">
                <img src="https://placedog.net/600/400?id=1" alt="Zurito">
                <p>Zurito - 1 año</p>
            </div>
        </div>
        <div class="swiper-slide">
            <div class="card">
                <img src="https://placedog.net/600/400?id=2" alt="Hanna">
                <p>Hanna - 3 meses</p>
            </div>
        </div>
        @endforelse

    </div>

    <!-- Botones -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

    <!-- Paginación -->
    <div class="swiper-pagination"></div>
</div>

<!-- Ubicación -->
<h2>📍 Nuestra ubicación</h2>
<div style="height: 400px; width: 100%; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); margin-bottom: 30px;">
    <iframe
        width="100%"
        height="100%"
        style="border:0;"
        loading="lazy"
        allowfullscreen
        src="https://www.google.com/maps?q=10.920758332832074,-74.824875070815&output=embed">
    </iframe>
</div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Inicializar carrusel
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    </script>

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">
    @include('partials.animal_modal')


    @endsection