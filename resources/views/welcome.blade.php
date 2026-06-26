@extends('layouts.adopter.app')

@section('title', 'SDAANIM | Adopción de Mascotas')

@section('content')

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Hero Section -->
    <div class="hero-container">
        <div class="hero-info">
            <div class="hero-badge">
                <span class="badge-paw">🐾</span>
                <span>Cada adopción cambia dos vidas</span>
            </div>
            <h1 class="hero-title">
                No compres,<br>
                <span class="hero-title-accent">adopta amor</span>
            </h1>
            <p class="hero-description">
                En SDAANIM conectamos peludos increíbles con familias extraordinarias. Todos los animales necesitan nuestra protección. ¡Ayúdanos hoy!
            </p>
            <div class="hero-buttons">
                <a href="#recien-llegados" class="hero-btn hero-btn-primary">
                    <span>🐾 Conoce a los animales</span>
                </a>
                <a href="#como-funciona" class="hero-btn hero-btn-secondary">
                    <span>▶ Cómo funciona</span>
                </a>
            </div>
        </div>
        <div class="hero-graphics">
            <div class="hero-blob"></div>
            <div class="hero-img-wrapper">
                <img src="{{ asset('img/hero_dogs.png') }}" alt="Perros para adopción">
            </div>
            <div class="hero-stats-card">
                <div class="stats-icon-circle">🐾</div>
                <div class="stats-info">
                    <span class="stats-number">+1,250</span>
                    <span class="stats-label">vidas cambiadas</span>
                    <div class="stats-avatars">
                        <img src="https://i.pravatar.cc/100?img=12" class="stats-avatar" alt="Avatar">
                        <img src="https://i.pravatar.cc/100?img=33" class="stats-avatar" alt="Avatar">
                        <img src="https://i.pravatar.cc/100?img=60" class="stats-avatar" alt="Avatar">
                        <div class="stats-avatar-more">+99</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Cards Section -->
    <div class="value-bar-section">
        <div class="value-bar">
            <div class="value-item">
                <div class="value-icon-wrapper">🔍</div>
                <div class="value-text-group">
                    <span class="value-item-title">Explora</span>
                    <span class="value-item-desc">Encuentra a tu compañero ideal.</span>
                </div>
            </div>
            <div class="value-item">
                <div class="value-icon-wrapper">🧡</div>
                <div class="value-text-group">
                    <span class="value-item-title">Conecta</span>
                    <span class="value-item-desc">Conoce su historia y da el paso.</span>
                </div>
            </div>
            <div class="value-item">
                <div class="value-icon-wrapper">✅</div>
                <div class="value-text-group">
                    <span class="value-item-title">Adopta</span>
                    <span class="value-item-desc">Te guiamos en todo el proceso.</span>
                </div>
            </div>
            <div class="value-item">
                <div class="value-icon-wrapper">🏠</div>
                <div class="value-text-group">
                    <span class="value-item-title">Transforma</span>
                    <span class="value-item-desc">Dale un hogar y recibe amor.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ¿Cómo funciona? Section -->
    <div class="how-section" id="como-funciona">
        <div class="section-title-wrapper">
            <h2 class="section-main-title">¿Cómo funciona?</h2>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <span class="step-number">1</span>
                <div class="step-icon-box">🔍</div>
                <h3 class="step-title">Explora</h3>
                <p class="step-desc">Busca entre nuestros peludos disponibles.</p>
            </div>
            <div class="step-card">
                <span class="step-number">2</span>
                <div class="step-icon-box">📋</div>
                <h3 class="step-title">Postúlate</h3>
                <p class="step-desc">Completa el formulario de adopción.</p>
            </div>
            <div class="step-card">
                <span class="step-number">3</span>
                <div class="step-icon-box">🏠</div>
                <h3 class="step-title">Entrevista</h3>
                <p class="step-desc">Conocemos tu perfil y resolvemos dudas.</p>
            </div>
            <div class="step-card">
                <span class="step-number">4</span>
                <div class="step-icon-box">🐶</div>
                <h3 class="step-title">¡Bienvenido a casa!</h3>
                <p class="step-desc">Tu nuevo mejor amigo te está esperando.</p>
            </div>
        </div>
    </div>

    <!-- Recién llegados -->
    <div class="section-header" id="recien-llegados">
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
<h2 class="location-section-title">📍 Nuestra ubicación</h2>
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