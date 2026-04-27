@extends('layouts.adopter.app')

@section('title', 'Redes Sociales & Horarios | Esperanza Animal BQ')

@section('content')
<link rel="stylesheet" href="{{ asset('css/shared/pages.css') }}">

<main class="quienes-somos">

    {{-- BANNER --}}
    <section class="banner-quienes" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
        <h2 style="font-family:'Pacifico',cursive; font-size:2.4em;">📱 Síguenos & Conéctate</h2>
        <p>Estamos en todas las redes. ¡Únete a nuestra comunidad y apoya a los peluditos!</p>
    </section>

    {{-- REDES SOCIALES --}}
    <section class="seccion" style="border-left-color: #e1306c; background: #fff5f8;">
        <h3 style="color:#c31163;">🌐 Nuestras Redes Sociales</h3>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:18px; margin-top:10px;">

            <a href="https://www.instagram.com" target="_blank" rel="noopener"
               style="display:flex; align-items:center; gap:14px; background: linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color:#fff; padding:18px 20px; border-radius:16px; text-decoration:none; font-weight:700; font-size:1.05em; box-shadow:0 6px 20px rgba(220,39,67,0.3); transition:transform .2s ease, box-shadow .2s ease;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 28px rgba(220,39,67,0.45)'"
               onmouseout="this.style.transform=''; this.style.boxShadow='0 6px 20px rgba(220,39,67,0.3)'">
                <span style="font-size:2em;">📸</span>
                <div>
                    <div>Instagram</div>
                    <small style="opacity:.85; font-weight:400;">@EsperanzaAnimalBQ</small>
                </div>
            </a>

            <a href="https://www.facebook.com" target="_blank" rel="noopener"
               style="display:flex; align-items:center; gap:14px; background: linear-gradient(135deg,#1877f2,#0d5bbf); color:#fff; padding:18px 20px; border-radius:16px; text-decoration:none; font-weight:700; font-size:1.05em; box-shadow:0 6px 20px rgba(24,119,242,0.3); transition:transform .2s ease, box-shadow .2s ease;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 28px rgba(24,119,242,0.45)'"
               onmouseout="this.style.transform=''; this.style.boxShadow='0 6px 20px rgba(24,119,242,0.3)'">
                <span style="font-size:2em;">👥</span>
                <div>
                    <div>Facebook</div>
                    <small style="opacity:.85; font-weight:400;">Esperanza Animal BQ</small>
                </div>
            </a>

            <a href="https://www.x.com" target="_blank" rel="noopener"
               style="display:flex; align-items:center; gap:14px; background: linear-gradient(135deg,#14171a,#38444d); color:#fff; padding:18px 20px; border-radius:16px; text-decoration:none; font-weight:700; font-size:1.05em; box-shadow:0 6px 20px rgba(0,0,0,0.25); transition:transform .2s ease, box-shadow .2s ease;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 28px rgba(0,0,0,0.4)'"
               onmouseout="this.style.transform=''; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.25)'">
                <span style="font-size:2em;">𝕏</span>
                <div>
                    <div>X (Twitter)</div>
                    <small style="opacity:.85; font-weight:400;">@EsperanzaAnimalBQ</small>
                </div>
            </a>

        </div>
    </section>

    {{-- HORARIOS --}}
    <section class="seccion" style="border-left-color: #f59e0b; background: #fffbeb;">
        <h3 style="color:#b45309;">🕐 Horarios de Apertura</h3>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap:14px; margin-top:8px;">

            <div style="background:#fff; border-radius:14px; padding:18px; text-align:center; box-shadow:0 3px 12px rgba(245,158,11,0.15); border-top:4px solid #f59e0b;">
                <div style="font-size:2em; margin-bottom:8px;">📅</div>
                <div style="font-weight:800; color:#92400e; font-size:1em; margin-bottom:6px;">Lunes – Viernes</div>
                <div style="color:#a16207; font-size:1.15em; font-weight:700;">10:00 AM – 4:00 PM</div>
            </div>

            <div style="background:#fff; border-radius:14px; padding:18px; text-align:center; box-shadow:0 3px 12px rgba(245,158,11,0.15); border-top:4px solid #10b981;">
                <div style="font-size:2em; margin-bottom:8px;">📅</div>
                <div style="font-weight:800; color:#065f46; font-size:1em; margin-bottom:6px;">Sábado</div>
                <div style="color:#047857; font-size:1.15em; font-weight:700;">10:30 AM – 2:00 PM</div>
            </div>

            <div style="background:#fff; border-radius:14px; padding:18px; text-align:center; box-shadow:0 3px 12px rgba(0,0,0,0.08); border-top:4px solid #ef4444; opacity:.75;">
                <div style="font-size:2em; margin-bottom:8px;">🚫</div>
                <div style="font-weight:800; color:#7f1d1d; font-size:1em; margin-bottom:6px;">Domingo & Festivos</div>
                <div style="color:#dc2626; font-size:1.1em; font-weight:700;">Cerrado</div>
            </div>

        </div>
        <p style="margin-top:14px; color:#92400e; font-size:0.9em;">
            📍 <strong>Dirección:</strong> Barranquilla, Colombia &nbsp;|&nbsp;
            📞 <strong>Teléfono:</strong> contacto@adoptaya.com
        </p>
    </section>

    {{-- RESEÑAS --}}
    <section class="seccion" style="border-left-color: #2d7d46; background: #f0fdf4;">
        <h3 style="color:#166534;">⭐ Experiencias de Adoptantes</h3>
        <p style="color:#4b7c5f; margin-bottom:20px; font-size:0.95em;">Estas son las opiniones reales de quienes ya vivieron el proceso de adopción con nosotros.</p>

        @if($reviews->count() > 0)
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(270px,1fr)); gap:16px;">
            @foreach($reviews as $rev)
            <div style="background:#fff; border-radius:16px; padding:20px; box-shadow:0 4px 14px rgba(0,0,0,0.07); border-bottom:4px solid #2d7d46;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                    <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#2d7d46,#4caf50); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:1.1em;">
                        {{ strtoupper(substr($rev->user->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:700; color:#1a3a2a; font-size:0.95em;">{{ $rev->user->name ?? 'Adoptante' }}</div>
                        <small style="color:#6b7280;">{{ $rev->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div style="margin-bottom:8px;">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color:{{ $i <= $rev->rev_estrellas ? '#f59e0b' : '#d1d5db' }}; font-size:1.1em;">★</span>
                    @endfor
                </div>
                @if($rev->rev_comentario)
                    <p style="color:#4b5563; font-size:0.88em; line-height:1.6; margin:0; font-style:italic;">"{{ $rev->rev_comentario }}"</p>
                @endif
                @if($rev->solicitud?->animal)
                    <small style="color:#2d7d46; font-weight:600; display:block; margin-top:8px;">🐾 Adopté a {{ $rev->solicitud->animal->Anim_nombre }}</small>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center; padding:40px; color:#6b7280;">
            <div style="font-size:3em; margin-bottom:12px;">🐾</div>
            <p>Aún no hay reseñas. ¡Sé el primero en compartir tu experiencia!</p>
        </div>
        @endif
    </section>

</main>
@endsection
