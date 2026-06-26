@extends('layouts.adopter.app')

@section('title', 'Mi Panel | Esperanza Animal BQ')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/adopter/dashboard.css') }}">
    <style>
        .adopter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 60px; /* Espacio con el mapa */
            width: 100%;
            box-sizing: border-box;
        }
        .premium-card {
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }
        .premium-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection

@section('content')

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <div class="welcome-jumbotron">
        <h1>¡Hola, {{ Auth::user()->name }}! 🐾</h1>
        <p>Gracias por ser parte de nuestra comunidad y apoyarnos en nuestra misión de rescatar vidas y conectar felicidad.</p>
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
            @endforelse

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Ubicación -->
    <h2 class="location-section-title">📍 Nuestra ubicación</h2>
    <div style="height: 400px; width: 100%; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <iframe
            width="100%"
            height="100%"
            style="border:0;"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps?q=10.920758332832074,-74.824875070815&output=embed">
        </iframe>
    </div>

    <div class="adopter-grid">
        <div class="premium-card">
            <span class="icon">🐶</span>
            <h3>Busca un Amigo</h3>
            <p>Explora nuestro catálogo de peluditos que buscan un hogar para siempre.</p>
            <a href="{{ route('adopta') }}" class="premium-btn-adopter">Ver Perros</a>
        </div>
        
        <div class="premium-card">
            <span class="icon">📋</span>
            <h3>Mis Solicitudes</h3>
            <p>Has enviado <strong>{{ $requestsCount ?? 0 }}</strong> solicitud{{ ($requestsCount ?? 0) === 1 ? '' : 'es' }}. Sigue el estado de tus procesos de adopción en tiempo real.</p>
            <a href="{{ route('adopter.requests') }}" class="premium-btn-adopter">Ver Solicitudes</a>
        </div>

        <div class="premium-card">
            <span class="icon">🛍️</span>
            <h3>Tienda Animal</h3>
            <p>Compra accesorios, comida y juguetes. Las ganancias salvan vidas.</p>
            <a href="{{ route('products.public') }}" class="premium-btn-adopter">Ver Productos</a>
        </div>

        <div class="premium-card">
            <span class="icon">🏢</span>
            <h3>Quiénes Somos</h3>
            <p>Conoce nuestra misión, visión y los valores que nos mueven.</p>
            <a href="{{ route('about') }}" class="premium-btn-adopter">Conocer más</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });

    </script>

    <!-- MODAL -->
    <div id="animalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <img id="modalImg" src="" alt="" style="width: 100%; border-radius: 10px;">
            <h2 id="modalNombre" style="color: #2d7d46; margin-top: 15px;"></h2>
            <p><strong>Edad:</strong> <span id="modalEdad"></span></p>
            <p><strong>Raza:</strong> <span id="modalRaza"></span></p>
            <p id="modalHistoria" style="margin-top: 15px; color: #64748b; text-align: justify;"></p>
        </div>
    </div>

    <script>
        function abrirModal(nombre, edad, raza, historia, foto) {
            document.getElementById('modalNombre').innerText = nombre;
            document.getElementById('modalEdad').innerText = edad;
            document.getElementById('modalRaza').innerText = raza;
            document.getElementById('modalHistoria').innerText = historia;
            document.getElementById('modalImg').src = foto;
            document.getElementById('animalModal').style.display = 'block';
        }
        function cerrarModal() { document.getElementById('animalModal').style.display = 'none'; }
        window.onclick = function(e) {
            const modal = document.getElementById('animalModal');
            if (e.target === modal) modal.style.display = "none";
        }
    </script>

@endsection
