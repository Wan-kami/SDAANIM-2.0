@extends('layouts.adopter.app')

@section('title', 'Mis Solicitudes | Esperanza Animal BQ')

@section('content')
<div style="max-width: 1000px; margin: 30px auto; padding: 20px;">
    <h2 style="color:#2d7d46; font-family:'Pacifico',cursive;">🐾 Mis Solicitudes de Adopción</h2>
    <p style="color:#64748b;">Historial y estado actual de tus aplicaciones.</p>

    <div style="margin-top: 30px;">
        @forelse($requests as $req)
            @php
                $decidido = in_array($req->Soli_estado, ['Aceptada', 'Rechazada', 'Aprobada', 'No Apta']);
                $yaCalificó = \App\Models\AdoptionReview::where('soli_id', $req->Soli_id)->exists();
                $colores = [
                    'Pendiente'      => ['bg'=>'#fff3cd', 'color'=>'#856404'],
                    'En Proceso'     => ['bg'=>'#e0f7fa', 'color'=>'#006064'],
                    'En Revisión'    => ['bg'=>'#e0f0ff', 'color'=>'#1e3a8a'],
                    'Asignada'       => ['bg'=>'#ede9fe', 'color'=>'#5b21b6'],
                    'En Entrevista'  => ['bg'=>'#fce7f3', 'color'=>'#831843'],
                    'Aprobada'       => ['bg'=>'#d4edda', 'color'=>'#155724'],
                    'Aceptada'       => ['bg'=>'#d4edda', 'color'=>'#155724'],
                    'Rechazada'      => ['bg'=>'#f8d7da', 'color'=>'#721c24'],
                    'No Apta'        => ['bg'=>'#f8d7da', 'color'=>'#721c24'],
                ];
                $c = $colores[$req->Soli_estado] ?? ['bg'=>'#f3f4f6','color'=>'#374151'];
            @endphp

            <div style="background: white; padding: 20px; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); margin-bottom: 20px; display: flex; align-items: center; gap: 20px; border-left: 5px solid {{ $c['color'] }};">
                <img src="{{ asset('img/' . ($req->animal->Anim_foto ?? 'placeholder.jpg')) }}"
                     style="width:90px; height:90px; border-radius:12px; object-fit:cover; flex-shrink:0;">

                <div style="flex: 1;">
                    <h3 style="margin:0 0 6px; color:#1a3a2a;">{{ $req->animal->Anim_nombre ?? 'Animal no disponible' }}</h3>
                    @if($req->reporte_voluntario)
                        <p style="margin:0 0 8px; color:#0f172a; font-size:0.92em; font-weight:700;">📌 Reporte recibido del voluntario</p>
                    @endif
                    @php
                        $fechaSolicitud = $req->Soli_fecha;
                        if ($fechaSolicitud && ! ($fechaSolicitud instanceof \Carbon\Carbon)) {
                            try {
                                $fechaSolicitud = \Carbon\Carbon::parse($fechaSolicitud);
                            } catch (\Exception $e) {
                                $fechaSolicitud = null;
                            }
                        }
                    @endphp
                    @php
                        $fechaVisita = $req->visita_fecha;
                        if ($fechaVisita && ! ($fechaVisita instanceof \Carbon\Carbon)) {
                            try {
                                $fechaVisita = \Carbon\Carbon::parse($fechaVisita);
                            } catch (\Exception $e) {
                                $fechaVisita = null;
                            }
                        }
                    @endphp
                    <p style="margin:0 0 4px; color:#64748b; font-size:0.9em;"><strong>Fecha:</strong> {{ $fechaSolicitud ? $fechaSolicitud->format('d/m/Y') : (optional($req->created_at)->format('d/m/Y') ?? 'Sin fecha') }}</p>
                    <p style="margin:0;">
                        <strong>Estado:</strong>
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.82em; font-weight: 700; background: {{ $c['bg'] }}; color: {{ $c['color'] }};">
                            {{ $req->Soli_estado }}
                        </span>
                    </p>

                    {{-- Calificación estrellada si el proceso terminó y aún no calificó --}}
                    @if($decidido && !$yaCalificó)
                        <button type="button"
                                class="review-button"
                                data-soli-id="{{ $req->Soli_id }}"
                                data-animal-nombre="{{ e($req->animal->Anim_nombre ?? 'Animal no disponible') }}"
                                style="margin-top:10px; padding:7px 16px; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border:none; border-radius:999px; font-size:0.82em; font-weight:700; cursor:pointer; box-shadow:0 4px 12px rgba(245,158,11,0.3); transition:.2s;"
                                onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                            ⭐ Calificar mi experiencia
                        </button>
                    @elseif($decidido && $yaCalificó)
                        <span style="display:inline-block; margin-top:10px; color:#2d7d46; font-size:0.82em; font-weight:700;">✅ ¡Gracias por tu reseña!</span>
                    @endif
                </div>

                <button type="button"
                        class="detail-button"
                        data-estado="{{ e($req->Soli_estado) }}"
                        data-comentario="{{ e($req->Soli_comentarios ?? 'No hay comentarios adicionales.') }}"
                        data-reporte="{{ e($req->reporte_voluntario ?? 'Aún no se ha recibido un reporte.') }}"
                        data-visita="{{ e($fechaVisita ? $fechaVisita->format('d/m/Y') : 'Fecha de visita no programada') }}"
                        data-volunteer="{{ e($req->volunteer?->name ?? 'No hay voluntario asignado') }}"
                        data-animal-nombre="{{ e($req->animal->Anim_nombre ?? 'Animal no disponible') }}"
                        style="background:none; border:none; padding:0; text-decoration:none; color:#2d7d46; font-weight:700; font-size:0.9em; white-space:nowrap; cursor:pointer;">
                    🔍 Ver detalles
                </button>
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px; color:#9ca3af;">
                <div style="font-size:4em; margin-bottom:16px;">🐾</div>
                <p style="font-size:1.1em;">Aún no has enviado ninguna solicitud.</p>
                <a href="{{ route('adopta') }}" style="display:inline-block; margin-top:16px; background:#2d7d46; color:#fff; padding:12px 28px; border-radius:999px; text-decoration:none; font-weight:700;">
                    Ver animales disponibles
                </a>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL: calificar experiencia --}}
<div id="reviewModal" style="display:none; position:fixed; inset:0; z-index:1300; background:rgba(0,0,0,0.55); backdrop-filter:blur(3px); align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:22px; padding:36px 38px; width:95%; max-width:470px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.25); animation:slideUp .3s ease; border-top:5px solid #f59e0b;">
        <button onclick="cerrarModalReview()" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;">✕</button>
        <h2 style="margin:0 0 6px; color:#92400e; font-size:1.3em;">⭐ Califica tu experiencia</h2>
        <p id="reviewSubtitle" style="color:#6b7280; font-size:0.9em; margin-bottom:20px;"></p>

        <form id="reviewForm" method="POST">
            @csrf

            {{-- Estrellas --}}
            <div style="text-align:center; margin-bottom:20px;" id="starContainer">
                @for($i = 1; $i <= 5; $i++)
                    <span data-val="{{ $i }}"
                          onclick="seleccionarEstrella({{ $i }})"
                          onmouseover="hoverEstrella({{ $i }})"
                          onmouseout="resetHover()"
                          style="font-size:2.4em; cursor:pointer; color:#d1d5db; transition:color .15s ease; user-select:none;">★</span>
                @endfor
            </div>
            <input type="hidden" name="rev_estrellas" id="inputEstrellas" value="">

            <label style="display:block; font-weight:700; color:#374151; margin-bottom:6px;">Cuéntanos tu experiencia <span style="color:#9ca3af; font-weight:400;">(opcional)</span></label>
            <textarea name="rev_comentario" rows="3" maxlength="500"
                      placeholder="¿Cómo fue el proceso? ¿Qué te pareció la atención?"
                      style="width:100%; box-sizing:border-box; border:1px solid #d1d5db; border-radius:12px; padding:12px; font-size:0.92em; resize:vertical; font-family:inherit;"></textarea>

            <button type="submit" id="btnEnviarReview"
                    style="margin-top:16px; width:100%; padding:14px; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border:none; border-radius:999px; font-weight:700; font-size:1em; cursor:pointer; box-shadow:0 6px 18px rgba(245,158,11,0.35);">
                Enviar reseña ⭐
            </button>
        </form>
    </div>
</div>

@include('partials.animal_modal')

{{-- MODAL: estado de la solicitud --}}
<div id="statusModal" style="display:none; position:fixed; inset:0; z-index:1400; background:rgba(0,0,0,0.55); backdrop-filter:blur(3px); align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:22px; padding:32px 36px; width:95%; max-width:520px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.25); animation:slideUp .3s ease; border-top:5px solid #2e8b57;">
        <button onclick="cerrarModalEstado()" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;">✕</button>
        <h2 id="statusModalTitle" style="margin:0 0 10px; color:#2e8b57; font-size:1.4em;"></h2>
        <p id="statusModalMessage" style="color:#4b5563; line-height:1.7; margin-bottom:24px;"></p>
        <div style="background:#f8fafc; border:1px solid #d1e8ee; border-radius:16px; padding:18px;">
            <p style="margin:0 0 8px; font-weight:700; color:#0f172a;">Información de la solicitud</p>
            <p style="margin:0 0 6px; color:#374151;"><strong>Estado:</strong> <span id="statusModalState" style="font-weight:700;"></span></p>
            <p style="margin:0 0 6px; color:#374151;"><strong>Voluntario asignado:</strong> <span id="statusModalVolunteer"></span></p>
            <p style="margin:0 0 6px; color:#374151;"><strong>Fecha de visita:</strong> <span id="statusModalVisit"></span></p>
            <p style="margin:0 0 6px; color:#374151;"><strong>Comentario del solicitante:</strong> <span id="statusModalRequestComment"></span></p>
            <p style="margin:0; color:#374151;"><strong>Reporte del voluntario:</strong> <span id="statusModalVolunteerReport"></span></p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let estrellasSeleccionadas = 0;

        window.abrirModalEstado = function(estado, comentario, reporte, visita, voluntario, animalNombre) {
            const title = estado === 'Aceptada' ? '¡Solicitud aceptada!' : estado === 'Rechazada' ? 'Solicitud rechazada' : 'Estado de tu solicitud';
            const statusModal = document.getElementById('statusModal');
            const reviewModal = document.getElementById('reviewModal');

            document.getElementById('statusModalTitle').innerText = title;

            let message = '';
            if (estado === 'Aceptada') {
                message = `Tu solicitud para ${animalNombre} fue aceptada. Gracias por confiar en nosotros. Revisa los detalles y prepárate para el próximo paso.`;
            } else if (estado === 'Rechazada') {
                message = `Lo sentimos, tu solicitud para ${animalNombre} fue rechazada. Puedes revisar más abajo los motivos disponibles o contactarnos para mayor información.`;
            } else if (estado === 'Aprobada') {
                message = `Tu solicitud para ${animalNombre} está aprobada y lista para continuar. Revisa los detalles de la visita y el seguimiento.`;
            } else if (estado === 'No Apta') {
                message = `Tu solicitud para ${animalNombre} no fue considerada apta en este momento. Revisa más abajo los comentarios de la revisión.`;
            } else if (estado === 'En Revisión' || estado === 'Asignada' || estado === 'En Entrevista' || estado === 'En Proceso') {
                message = `Tu solicitud para ${animalNombre} está en revisión. Pronto recibirás novedades del voluntario asignado y la visita programada.`;
            } else {
                message = `Tu solicitud para ${animalNombre} está en estado "${estado}". Revisa más detalles a continuación.`;
            }

            document.getElementById('statusModalMessage').innerText = message;
            document.getElementById('statusModalState').innerText = estado;
            document.getElementById('statusModalVolunteer').innerText = voluntario;
            document.getElementById('statusModalVisit').innerText = visita;
            document.getElementById('statusModalRequestComment').innerText = comentario || 'No hay comentarios adicionales.';
            document.getElementById('statusModalVolunteerReport').innerText = reporte || 'Aún no se ha recibido un reporte.';
            statusModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        window.cerrarModalEstado = function() {
            const statusModal = document.getElementById('statusModal');
            if (statusModal) {
                statusModal.style.display = 'none';
                document.body.style.overflow = '';
            }
        };

        window.abrirModalReview = function(soliId, animalNombre) {
            const reviewForm = document.getElementById('reviewForm');
            if (!reviewForm) return;

            reviewForm.action = '/adopter/mis-solicitudes/' + soliId + '/calificar';
            document.getElementById('reviewSubtitle').innerText = 'Adoptaste a ' + animalNombre + '. Tu opinión nos ayuda a mejorar 🐾';
            document.getElementById('reviewModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            estrellasSeleccionadas = 0;
            document.getElementById('inputEstrellas').value = '';
            resetHover();
        };

        window.cerrarModalReview = function() {
            const reviewModal = document.getElementById('reviewModal');
            if (reviewModal) {
                reviewModal.style.display = 'none';
                document.body.style.overflow = '';
            }
        };

        window.seleccionarEstrella = function(val) {
            estrellasSeleccionadas = val;
            document.getElementById('inputEstrellas').value = val;
            colorEstrellas(val, '#f59e0b');
        };

        window.hoverEstrella = function(val) {
            colorEstrellas(val, '#fbbf24');
        };

        const reviewButtons = document.querySelectorAll('.review-button');
        reviewButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                window.abrirModalReview(this.dataset.soliId, this.dataset.animalNombre);
            });
        });

        const detailButtons = document.querySelectorAll('.detail-button');
        detailButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                window.abrirModalEstado(
                    this.dataset.estado,
                    this.dataset.comentario,
                    this.dataset.reporte,
                    this.dataset.visita,
                    this.dataset.volunteer,
                    this.dataset.animalNombre
                );
            });
        });

        function resetHover() {
            colorEstrellas(estrellasSeleccionadas, '#f59e0b');
            const spans = document.querySelectorAll('#starContainer span');
            spans.forEach((s, i) => {
                if (i >= estrellasSeleccionadas) s.style.color = '#d1d5db';
            });
        }

        function colorEstrellas(val, color) {
            const spans = document.querySelectorAll('#starContainer span');
            spans.forEach((s, i) => {
                s.style.color = i < val ? color : '#d1d5db';
            });
        }

        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                if (!document.getElementById('inputEstrellas').value) {
                    e.preventDefault();
                    alert('Por favor selecciona al menos una estrella ⭐');
                }
            });
        }

        const reviewModal = document.getElementById('reviewModal');
        if (reviewModal) {
            reviewModal.addEventListener('click', function(e) {
                if (e.target === this) cerrarModalReview();
            });
        }
    });
</script>
@endsection
