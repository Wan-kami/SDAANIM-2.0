@extends('layouts.adopter.app')

@section('title', 'Modelo de Negocio | Esperanza Animal BQ')

@section('content')
<link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<main class="quienes-somos">

    {{-- BANNER --}}
    <section class="banner-quienes" style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 60%, #1d4ed8 100%);">
        <h2 style="font-family:'Pacifico',cursive; font-size:2.4em;">💼 Cómo nos sostenemos</h2>
        <p>Conoce las fuentes que hacen posible nuestra misión de rescate y adopción responsable.</p>
    </section>

    {{-- GRID MODELO --}}
    <div class="quienes-grid">

        <section class="seccion" style="border-left-color:#2563eb; background:#eff6ff;">
            <h3 style="color:#1e40af;">📢 Publicidad Pet-Friendly</h3>
            <p>Colaboramos con marcas que comparten nuestros valores. Empresas de alimentos, accesorios y salud animal pueden pautar en nuestra plataforma digital y eventos, llegando a miles de amantes de las mascotas en Barranquilla.</p>
            <ul style="margin-top:14px; color:#1e3a8a; padding-left:20px; line-height:1.9;">
                <li>Banners en la plataforma digital</li>
                <li>Patrocinio de jornadas de adopción</li>
                <li>Menciones en redes sociales</li>
                <li>Co-branding en eventos comunitarios</li>
            </ul>
        </section>

        <section class="seccion" style="border-left-color:#10b981; background:#ecfdf5;">
            <h3 style="color:#065f46;">🛒 Venta de Productos</h3>
            <p>Nuestra tienda en línea ofrece productos de calidad para mascotas. Cada compra contribuye directamente al bienestar de los animales del refugio. Alimentos, accesorios y artículos de higiene disponibles en nuestra plataforma.</p>
            <ul style="margin-top:14px; color:#064e3b; padding-left:20px; line-height:1.9;">
                <li>Alimentos balanceados premium</li>
                <li>Accesorios y juguetes</li>
                <li>Productos de higiene y salud</li>
                <li>Ropa y artículos personalizados</li>
            </ul>
            <a href="{{ route('products.public') }}" style="display:inline-block; margin-top:16px; background:#10b981; color:#fff; padding:10px 22px; border-radius:999px; text-decoration:none; font-weight:700; font-size:0.9em; transition:.2s;"
               onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                Ver Tienda →
            </a>
        </section>

    </div>

    <div class="quienes-grid">



        <section class="seccion" style="border-left-color:#8b5cf6; background:#f5f3ff;">
            <h3 style="color:#5b21b6;">🤝 Alianzas Estratégicas</h3>
            <p>Trabajamos con clínicas veterinarias, petshops y organizaciones no gubernamentales. Estas alianzas nos permiten ofrecer servicios de calidad a costo reducido, maximizando el impacto de cada peso recibido.</p>
            <ul style="margin-top:14px; color:#4c1d95; padding-left:20px; line-height:1.9;">
                <li>Clínicas veterinarias aliadas</li>
                <li>Descuentos en productos para adoptantes</li>
                <li>Redes de voluntariado corporativo</li>
            </ul>
        </section>

    </div>

    {{-- CTA --}}
    <section class="seccion" style="text-align:center; border-left:none; border-top:6px solid #2563eb; background:linear-gradient(135deg,#eff6ff,#dbeafe);">
        <h3 style="color:#1e40af; justify-content:center;">🚀 ¿Quieres ser parte?</h3>
        <p style="max-width:560px; margin:0 auto 20px; color:#1e3a8a;">Si tienes una empresa, marca o eres profesional del sector y quieres colaborar con nuestra fundación, contáctanos.</p>
        <a href="{{ route('contact') }}" style="display:inline-block; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; padding:14px 36px; border-radius:999px; text-decoration:none; font-weight:800; font-size:1em; box-shadow:0 6px 20px rgba(37,99,235,0.35); transition:.2s;"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 28px rgba(37,99,235,0.5)'"
           onmouseout="this.style.transform=''; this.style.boxShadow='0 6px 20px rgba(37,99,235,0.35)'">
            📩 Contáctanos
        </a>
    </section>

</main>
@endsection
