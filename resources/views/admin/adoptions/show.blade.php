@extends('layouts.app')

@section('content')
<main style="padding: 40px 20px; background: #f5f5f5; min-height: 100vh;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <!-- Back Button -->
        <a href="{{ route('admin.adoptions') }}" style="display: inline-block; width: 45px; height: 45px; border-radius: 50%; background: #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 30px; transition: all 0.3s; text-decoration: none; color: #333;" onmouseover="this.style.background='#2e8b57'; this.style.color='white';" onmouseout="this.style.background='#e8e8e8'; this.style.color='#333';">←</a>

        <!-- Header Card -->
        <div style="background: linear-gradient(135deg, #2e8b57 0%, #4caf50 100%); border-radius: 8px; padding: 30px; color: white; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 10px 0; font-size: 28px; font-weight: 600;">📋 Detalle de Solicitud #{{ $adoption->Soli_id }}</h1>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Información completa de la solicitud de adopción</p>
        </div>

        <!-- Status Badge -->
        <div style="margin-bottom: 30px;">
            @php
                $statusColors = [
                    'Pendiente' => '#FFC107',
                    'En Revisión' => '#2196F3',
                    'Aceptada' => '#4CAF50',
                    'Rechazada' => '#f44336'
                ];
                $statusColor = $statusColors[$adoption->Soli_estado] ?? '#999';
            @endphp
            <span style="display: inline-block; background: {{ $statusColor }}; color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                {{ $adoption->Soli_estado }}
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Solicitante Card -->
            <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h3 style="margin-top: 0; color: #2e8b57; font-size: 16px; font-weight: 600; margin-bottom: 15px;">👤 Información del Solicitante</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Nombre</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Documento</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->Usu_documento }}</p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Email</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Dirección</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->user->Usu_direccion ?? 'No especificada' }}</p>
                    </div>
                </div>
            </div>

            <!-- Animal Card -->
            <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h3 style="margin-top: 0; color: #2e8b57; font-size: 16px; font-weight: 600; margin-bottom: 15px;">🐾 Información del Animal</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Nombre</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->animal->Anim_nombre ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Raza</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->animal->Anim_raza ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Edad</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->animal->Anim_edad ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
            <h3 style="margin-top: 0; color: #2e8b57; font-size: 16px; font-weight: 600; margin-bottom: 15px;">📝 Detalles de la Solicitud</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Fecha</label>
                    <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->Soli_fecha->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Motivo</label>
                    <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->Soli_motivo ?? 'No especificado' }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Otras mascotas</label>
                    <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->Soli_otras_mascotas ?? 'No' }}</p>
                </div>
                <div>
                    <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Tipo de vivienda</label>
                    <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->Soli_tipo_vivienda ?? 'No especificado' }}</p>
                </div>
            </div>
            <div style="margin-top: 20px;">
                <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Tiempo disponible</label>
                <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->Soli_tiempo_disponible ?? 'No especificado' }}</p>
            </div>
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Fecha de visita</label>
                <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->visita_fecha ? \Carbon\Carbon::parse($adoption->visita_fecha)->format('d/m/Y') : 'No programada' }}</p>
            </div>
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Comentarios</label>
                <p style="margin: 5px 0 0 0; color: #333; font-size: 14px; line-height: 1.6;">{{ $adoption->Soli_comentarios ?? 'Sin comentarios' }}</p>
            </div>
        </div>

        <!-- Volunteer Card (if assigned) -->
        @if($adoption->Soli_voluntario)
        <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
            <h3 style="margin-top: 0; color: #2e8b57; font-size: 16px; font-weight: 600; margin-bottom: 15px;">👨‍💼 Seguimiento</h3>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Voluntario asignado</label>
                <p style="margin: 5px 0 0 0; color: #333; font-size: 14px;">{{ $adoption->volunteer->name ?? 'N/A' }}</p>
            </div>

            @if($adoption->reporte_voluntario)
                @php
                    $evalBorderColor = $adoption->apto ? '#4CAF50' : '#f44336';
                    $evalBgColor = $adoption->apto ? '#e8f5e9' : '#ffebee';
                    $evalTextColor = $adoption->apto ? '#2e7d32' : '#c62828';
                    $evalBadge = $adoption->apto ? '✓ Apto' : '✕ No Apto';
                @endphp
                <div style="margin-top: 20px; padding: 15px; border-left: 5px solid {{ $evalBorderColor }}; background: {{ $evalBgColor }}; border-radius: 4px;">
                    <h4 style="margin: 0 0 10px 0; color: {{ $evalTextColor }}; font-size: 15px; font-weight: 600;">
                        Conclusión del Voluntario: <span style="font-weight: bold; text-transform: uppercase;">{{ $evalBadge }}</span>
                    </h4>
                    <label style="color: #666; font-size: 11px; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Reporte Detallado</label>
                    <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.5; white-space: pre-line;">{{ $adoption->reporte_voluntario }}</p>
                </div>
            @endif
        </div>
        @endif

        <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
            <h3 style="margin-top: 0; color: #2e8b57; font-size: 16px; font-weight: 600; margin-bottom: 15px;">📝 Reporte del Voluntario</h3>
            @if($adoption->reporte_voluntario)
                <div style="display: grid; gap: 15px;">
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">Reporte</label>
                        <p style="margin: 5px 0 0 0; color: #333; font-size: 14px; line-height: 1.6; white-space: pre-line;">{{ $adoption->reporte_voluntario }}</p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px; text-transform: uppercase; font-weight: 600;">¿Apto para adopción?</label>
                        @if($adoption->apto !== null)
                            <div style="margin-top: 6px;">
                                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 50px; font-weight: 700; font-size: 14px; {{ $adoption->apto ? 'background: #e8f5e9; color: #2e7d32; border: 2px solid #4CAF50;' : 'background: #ffebee; color: #c62828; border: 2px solid #f44336;' }}">
                                    {{ $adoption->apto ? '✓ Apto para adopción' : '✕ No apto para adopción' }}
                                </span>
                            </div>
                        @else
                            <p style="margin: 5px 0 0 0; color: #999; font-size: 14px; font-style: italic;">Pendiente</p>
                        @endif
                    </div>
                </div>
            @else
                <p style="margin: 0; color: #666; font-size: 14px;">Aún no se ha recibido el reporte del voluntario. El administrador debe revisar esta solicitud cuando el voluntario lo envíe.</p>
            @endif
        </div>

        <!-- Actions Card -->
        <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <h3 style="margin-top: 0; color: #2e8b57; font-size: 16px; font-weight: 600; margin-bottom: 20px;">⚙️ Acciones</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @if($adoption->Soli_estado == 'Pendiente')
                <a href="{{ route('admin.adoptions.assign', $adoption->Soli_id) }}" style="background: #2196F3; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.background='#1976D2'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#2196F3'; this.style.transform='translateY(0)';">Asignar Voluntario</a>
                @endif
                
                @if($adoption->Soli_estado == 'En Revisión')
                <a href="{{ route('admin.adoptions.approve', $adoption->Soli_id) }}" style="background: #4CAF50; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.background='#388E3C'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#4CAF50'; this.style.transform='translateY(0)';">✓ Aprobar</a>
                <a href="{{ route('admin.adoptions.reject', $adoption->Soli_id) }}" style="background: #f44336; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.background='#da190b'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#f44336'; this.style.transform='translateY(0)';">✕ Rechazar</a>
                @endif

                @if($adoption->Soli_estado == 'Aceptada' || $adoption->Soli_estado == 'En Revisión')
                <a href="{{ route('admin.adoptions.followup.create', $adoption->Soli_id) }}" style="background: #FF9800; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.background='#F57C00'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#FF9800'; this.style.transform='translateY(0)';">+ Seguimiento</a>
                @endif
            </div>
        </div>
    </div>
</main>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        h1 {
            font-size: 20px !important;
        }
    }
</style>
@endsection
