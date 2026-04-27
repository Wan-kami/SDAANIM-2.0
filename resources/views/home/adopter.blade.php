@extends('layouts.adopter.app')

@section('title', 'Mi Panel | Esperanza Animal BQ')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/adopter/dashboard.css') }}">
@endsection

@section('content')

    <!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <div class="premium-card" style="text-align: center; margin-bottom: 50px; background: linear-gradient(135deg, #ffffff, #f0fdf4); border-top: 8px solid #2d7d46;">
        <h1 style="font-family: 'Pacifico', cursive; color: #2d7d46; font-size: 3em; margin-bottom: 15px;">¡Hola, {{ Auth::user()->name }}! 🐾</h1>
        <p style="color: #64748b; font-size: 1.2em; max-width: 600px; margin: 0 auto;">Gracias por ser parte de nuestra comunidad y apoyarnos en nuestra misión de rescatar vidas.</p>
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
<div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>

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

        // Google Maps
        function initMap() {
            const ubicacion = {
                lat: 10.920758332832074,
                lng: -74.824875070815
            };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: ubicacion,
            });

            new google.maps.Marker({
                position: ubicacion,
                map: map,
                title: "Esperanza Animal BQ 🐾"
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSxjXAhrgyp8ytXfE_3WEjiFvGUz61woM&callback=initMap">
    </script>

    <div class="adopter-grid">
        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">🐶</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Busca un Amigo</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Explora nuestro catálogo de peluditos que buscan un hogar para siempre.</p>
            <a href="{{ route('adopta') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Ver Perros</a>
        </div>
        
        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">📋</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Mis Solicitudes</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Sigue el estado de tus procesos de adopción en tiempo real.</p>
            <a href="{{ route('adopter.requests') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Ver Solicitudes</a>
        </div>

        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">🛍️</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Tienda Animal</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Compra accesorios, comida y juguetes. Las ganancias salvan vidas.</p>
            <a href="{{ route('products.public') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Ver Productos</a>
        </div>

        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">🏢</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Quiénes Somos</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Conoce nuestra misión, visión y edita nuestra historia.</p>
            <a href="{{ route('adopter.history.edit') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Editar Historia</a>
        </div>
    </div>

    <!-- MODAL -->
    <div id="animalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>

            <img id="modalImg" src="" alt="">

            <h2 id="modalNombre"></h2>
            <p><strong>Edad:</strong> <span id="modalEdad"></span></p>
            <p><strong>Raza:</strong> <span id="modalRaza"></span></p>
            <p id="modalHistoria"></p>
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

        function cerrarModal() {
            document.getElementById('animalModal').style.display = 'none';
        }

        /* cerrar al hacer click afuera */
        window.onclick = function(e) {
            const modal = document.getElementById('animalModal');
            if (e.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>


@endsection
