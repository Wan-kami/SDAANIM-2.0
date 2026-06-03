@extends('layouts.app')

@section('content')
<main style="padding: 40px 20px; background: #f0f4f8; min-height: 100vh;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; width: fit-content; background: #e8e8e8; color: #333; padding: 10px 18px; border-radius: 50px; text-decoration: none; font-size: 14px; font-weight: 600; margin-bottom: 30px; transition: all 0.3s;" onmouseover="this.style.background='#2e8b57'; this.style.color='white';" onmouseout="this.style.background='#e8e8e8'; this.style.color='#333';">← Volver</a>

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #1b5e20 0%, #2e8b57 50%, #4caf50 100%); border-radius: 16px; padding: 32px; color: white; margin-bottom: 30px; box-shadow: 0 8px 24px rgba(46,139,87,0.3); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="margin: 0 0 6px 0; font-size: 26px; font-weight: 700;">📋 Solicitudes de Adopción</h1>
                <p style="margin: 0; font-size: 14px; opacity: 0.85;">Gestiona y revisa todas las solicitudes de adopción</p>
            </div>
            @php
                $conReporte = $adoptions->filter(fn($a) => !empty($a->reporte_voluntario))->count();
            @endphp
            @if($conReporte > 0)
            <div style="background: rgba(255,152,0,0.25); border: 2px solid rgba(255,152,0,0.6); padding: 14px 22px; border-radius: 12px; text-align: center; animation: pulse-badge 2s infinite;">
                <div style="font-size: 26px; font-weight: 700;">{{ $conReporte }}</div>
                <div style="font-size: 12px; font-weight: 600; opacity: 0.95;">⏳ Revisión Pendiente</div>
            </div>
            @elseif($adoptions->count() > 0)
            <div style="background: rgba(255,255,255,0.15); padding: 14px 22px; border-radius: 12px; text-align: center;">
                <div style="font-size: 26px; font-weight: 700;">{{ $adoptions->count() }}</div>
                <div style="font-size: 12px; opacity: 0.85;">Solicitudes</div>
            </div>
            @endif
        </div>

        @if(session('success'))
        <div style="background: #4CAF50; color: white; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">✓</span> {{ session('success') }}
        </div>
        @endif

        @if($adoptions->count() > 0)

        {{-- ============================================================ --}}
        {{-- SECCIÓN 1: SOLICITUDES CON REPORTE PENDIENTE DE REVISIÓN      --}}
        {{-- ============================================================ --}}
        @php $pendientesRevision = $adoptions->filter(fn($a) => !empty($a->reporte_voluntario) && !in_array($a->Soli_estado, ['Aceptada', 'Rechazada'])); @endphp

        @if($pendientesRevision->count() > 0)
        <div style="margin-bottom: 36px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="background: #FF6F00; color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                    🔔 REQUIEREN DECISIÓN DEL ADMINISTRADOR
                </div>
                <div style="height: 2px; flex: 1; background: linear-gradient(to right, #FF6F00, transparent);"></div>
            </div>

            @foreach($pendientesRevision as $adoption)
            @php $esApto = $adoption->apto; @endphp
            <div style="background: white; border-radius: 14px; margin-bottom: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.10); border: 2px solid {{ $esApto ? '#4CAF50' : '#f44336' }}; overflow: hidden; position: relative;">

                {{-- Banda superior de color --}}
                <div style="background: {{ $esApto ? 'linear-gradient(135deg, #1b5e20, #4CAF50)' : 'linear-gradient(135deg, #b71c1c, #f44336)' }}; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 20px;">{{ $esApto ? '✅' : '❌' }}</span>
                        <div>
                            <span style="color: white; font-weight: 700; font-size: 15px;">
                                Revisión #{{ $adoption->Soli_id }} — {{ $adoption->animal->Anim_nombre ?? 'N/A' }}
                            </span>
                            <span style="display: block; color: rgba(255,255,255,0.8); font-size: 12px; margin-top: 2px;">
                                Solicitante: {{ $adoption->user->name ?? $adoption->Usu_documento }} &nbsp;·&nbsp; Voluntario: {{ $adoption->volunteer->name ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div style="background: white; color: {{ $esApto ? '#2e7d32' : '#c62828' }}; padding: 6px 16px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                        {{ $esApto ? '✓ APTO' : '✕ NO APTO' }}
                    </div>
                </div>

                {{-- Cuerpo con el reporte y botones --}}
                <div style="padding: 20px 24px; display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
                    <div>
                        <p style="margin: 0 0 6px 0; font-size: 12px; font-weight: 700; color: #666; text-transform: uppercase; letter-spacing: 0.5px;">Reporte del Voluntario</p>
                        <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.6; background: #f9f9f9; padding: 12px 14px; border-radius: 8px; border-left: 4px solid {{ $esApto ? '#4CAF50' : '#f44336' }}; max-height: 100px; overflow-y: auto;">
                            {{ $adoption->reporte_voluntario }}
                        </p>
                        <div style="display: flex; gap: 16px; margin-top: 10px;">
                            <span style="font-size: 12px; color: #888;">🐾 Animal: <strong>{{ $adoption->animal->Anim_nombre ?? 'N/A' }}</strong></span>
                            <span style="font-size: 12px; color: #888;">📅 Fecha: <strong>{{ $adoption->Soli_fecha->format('d/m/Y') }}</strong></span>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px; min-width: 180px;">
                        <a href="{{ route('admin.adoptions.show', $adoption->Soli_id) }}"
                           style="background: #2196F3; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; text-align: center; transition: all 0.2s;"
                           onmouseover="this.style.background='#1565C0'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#2196F3'; this.style.transform='translateY(0)';">
                            🔍 Ver Detalle Completo
                        </a>
                        <a href="{{ route('admin.adoptions.approve', $adoption->Soli_id) }}"
                           style="background: #4CAF50; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700; text-align: center; transition: all 0.2s;"
                           onmouseover="this.style.background='#2E7D32'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#4CAF50'; this.style.transform='translateY(0)';"
                           onclick="return confirm('¿Aprobar la adopción de {{ addslashes($adoption->animal->Anim_nombre ?? '') }} para {{ addslashes($adoption->user->name ?? '') }}?')">
                            ✓ Aprobar Adopción
                        </a>
                        <a href="{{ route('admin.adoptions.reject', $adoption->Soli_id) }}"
                           style="background: #f44336; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700; text-align: center; transition: all 0.2s;"
                           onmouseover="this.style.background='#b71c1c'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#f44336'; this.style.transform='translateY(0)';"
                           onclick="return confirm('¿Rechazar la adopción de {{ addslashes($adoption->animal->Anim_nombre ?? '') }}?')">
                            ✕ Rechazar Adopción
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- ============================================================ --}}
        {{-- SECCIÓN 2: TABLA GENERAL DE TODAS LAS SOLICITUDES             --}}
        {{-- ============================================================ --}}
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="background: #37474f; color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                📄 Todas las Solicitudes
            </div>
            <div style="height: 2px; flex: 1; background: linear-gradient(to right, #37474f, transparent);"></div>
        </div>

        <div style="background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">ID</th>
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Solicitante</th>
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Animal</th>
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Fecha</th>
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Voluntario</th>
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Evaluación</th>
                            <th style="padding: 14px 16px; text-align: center; font-weight: 700; color: #2e8b57; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adoptions as $adoption)
                        @php
                            $tieneReporte = !empty($adoption->reporte_voluntario) && !in_array($adoption->Soli_estado, ['Aceptada', 'Rechazada']);
                            $statusColors = [
                                'Pendiente'   => '#FFC107',
                                'En Revisión' => '#2196F3',
                                'Aceptada'    => '#4CAF50',
                                'Rechazada'   => '#f44336',
                                'En Proceso'  => '#FF9800',
                            ];
                            $statusColor = $statusColors[$adoption->Soli_estado] ?? '#999';
                            $rowBg = $tieneReporte ? '#fff8e1' : 'white';
                        @endphp
                        <tr style="border-bottom: 1px solid #e0e0e0; background: {{ $rowBg }}; transition: background 0.2s;"
                            onmouseover="this.style.background='#f0f4f8';"
                            onmouseout="this.style.background='{{ $rowBg }}';">
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                    <span style="display: inline-block; background: #e3f2fd; color: #1976d2; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 13px;">
                                        #{{ $adoption->Soli_id }}
                                    </span>
                                    @if($tieneReporte)
                                    <span style="display: inline-block; background: #FF6F00; color: white; padding: 2px 7px; border-radius: 10px; font-size: 10px; font-weight: 700; letter-spacing: 0.3px; animation: pulse-badge 2s infinite;">
                                        📋 REVISIÓN
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 14px 16px; color: #333; font-size: 14px;">{{ $adoption->user->name ?? $adoption->Usu_documento }}</td>
                            <td style="padding: 14px 16px; color: #333; font-size: 14px; font-weight: 600;">{{ $adoption->animal->Anim_nombre ?? 'N/A' }}</td>
                            <td style="padding: 14px 16px; color: #666; font-size: 13px;">
                                <span style="background: #f0f0f0; padding: 3px 8px; border-radius: 4px;">
                                    {{ $adoption->Soli_fecha->format('d/m/Y') }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px;">
                                <span style="display: inline-block; background: {{ $statusColor }}; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                    {{ $adoption->Soli_estado }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px; color: #555; font-size: 13px;">{{ $adoption->volunteer->name ?? '—' }}</td>
                            <td style="padding: 14px 16px;">
                                @if($adoption->reporte_voluntario)
                                    @if($adoption->apto)
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 12px;">✓ Apto</span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 12px;">✕ No Apto</span>
                                    @endif
                                @else
                                    <span style="color: #aaa; font-size: 12px; font-style: italic;">Sin reporte</span>
                                @endif
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('admin.adoptions.show', $adoption->Soli_id) }}"
                                       style="background: #2196F3; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s;"
                                       onmouseover="this.style.background='#1565C0';" onmouseout="this.style.background='#2196F3';">
                                       Ver
                                    </a>

                                    @if($adoption->Soli_estado == 'Pendiente')
                                    <a href="{{ route('admin.adoptions.assign', $adoption->Soli_id) }}"
                                       style="background: #FF9800; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s;"
                                       onmouseover="this.style.background='#E65100';" onmouseout="this.style.background='#FF9800';">
                                       Asignar
                                    </a>
                                    @endif

                                    @if($adoption->Soli_estado == 'En Revisión')
                                    <a href="{{ route('admin.adoptions.approve', $adoption->Soli_id) }}"
                                       style="background: #4CAF50; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.2s;"
                                       onmouseover="this.style.background='#2E7D32';" onmouseout="this.style.background='#4CAF50';"
                                       onclick="return confirm('¿Aprobar esta adopción?')">✓</a>
                                    <a href="{{ route('admin.adoptions.reject', $adoption->Soli_id) }}"
                                       style="background: #f44336; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.2s;"
                                       onmouseover="this.style.background='#b71c1c';" onmouseout="this.style.background='#f44336';"
                                       onclick="return confirm('¿Rechazar esta adopción?')">✕</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @else
        <!-- Empty State -->
        <div style="background: white; border-radius: 14px; padding: 80px 40px; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
            <div style="font-size: 60px; margin-bottom: 20px;">📋</div>
            <h3 style="color: #666; font-size: 18px; margin: 0 0 10px 0;">No hay solicitudes de adopción</h3>
            <p style="color: #999; font-size: 14px; margin: 0;">Las solicitudes de adopción aparecerán aquí cuando se registren nuevas</p>
        </div>
        @endif

    </div>
</main>

<style>
    @keyframes pulse-badge {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.85; transform: scale(1.05); }
    }
    @media (max-width: 768px) {
        main { padding: 20px 15px !important; }
        h1   { font-size: 20px !important; }
        table { font-size: 12px !important; }
        td, th { padding: 10px 8px !important; }
        div[style*="grid-template-columns: 1fr auto"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection


@section('content')
<main style="padding: 40px 20px; background: #f5f5f5; min-height: 100vh;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}" style="display: inline-block; width: 45px; height: 45px; border-radius: 50%; background: #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 30px; transition: all 0.3s; text-decoration: none; color: #333;" onmouseover="this.style.background='#2e8b57'; this.style.color='white';" onmouseout="this.style.background='#e8e8e8'; this.style.color='#333';">←</a>

        <!-- Header Card -->
        <div style="background: linear-gradient(135deg, #2e8b57 0%, #4caf50 100%); border-radius: 8px; padding: 30px; color: white; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="margin: 0 0 10px 0; font-size: 28px; font-weight: 600;">📋 Solicitudes de Adopción</h1>
                <p style="margin: 0; font-size: 14px; opacity: 0.9;">Gestiona todas las solicitudes de adopción de animales</p>
            </div>
            @if($adoptions->count() > 0)
            <div style="background: rgba(255,255,255,0.2); padding: 15px 25px; border-radius: 50px; text-align: center;">
                <div style="font-size: 28px; font-weight: 700;">{{ $adoptions->count() }}</div>
                <div style="font-size: 12px; opacity: 0.9;">Solicitudes</div>
            </div>
            @endif
        </div>

        @if(session('success'))
        <div style="background: #4CAF50; color: white; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            ✓ {{ session('success') }}
        </div>
        @endif

        @if($adoptions->count() > 0)
        <!-- Table Card -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">ID</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Usuario</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Animal</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Fecha</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Estado</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Voluntario</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Evaluación</th>
                            <th style="padding: 16px; text-align: center; font-weight: 600; color: #2e8b57; font-size: 12px; text-transform: uppercase;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adoptions as $adoption)
                        <tr style="border-bottom: 1px solid #e0e0e0; transition: background 0.2s;" onmouseover="this.style.background='#f9f9f9';" onmouseout="this.style.background='white';">
                            <td style="padding: 16px;">
                                <span style="display: inline-block; background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 13px;">{{ $adoption->Soli_id }}</span>
                            </td>
                            <td style="padding: 16px; color: #333; font-size: 14px;">{{ $adoption->user->name ?? $adoption->Usu_documento }}</td>
                            <td style="padding: 16px; color: #333; font-size: 14px;">{{ $adoption->animal->Anim_nombre ?? 'N/A' }}</td>
                            <td style="padding: 16px; color: #666; font-size: 13px;">
                                <span style="display: inline-block; background: #f0f0f0; padding: 4px 8px; border-radius: 4px;">
                                    {{ $adoption->Soli_fecha->format('d/m/Y') }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                @php
                                    $statusColors = [
                                        'Pendiente' => '#FFC107',
                                        'En Revisión' => '#2196F3',
                                        'Aceptada' => '#4CAF50',
                                        'Rechazada' => '#f44336'
                                    ];
                                    $statusColor = $statusColors[$adoption->Soli_estado] ?? '#999';
                                @endphp
                                <span style="display: inline-block; background: {{ $statusColor }}; color: white; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 12px;">{{ $adoption->Soli_estado }}</span>
                            </td>
                            <td style="padding: 16px; color: #333; font-size: 14px;">{{ $adoption->volunteer->name ?? 'Sin asignar' }}</td>
                            <td style="padding: 16px;">
                                @if($adoption->reporte_voluntario)
                                    @if($adoption->apto)
                                        <span style="display: inline-block; background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">✓ Apto</span>
                                    @else
                                        <span style="display: inline-block; background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">✕ No Apto</span>
                                    @endif
                                @else
                                    <span style="color: #888; font-size: 13px; font-style: italic;">Pendiente</span>
                                @endif
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('admin.adoptions.show', $adoption->Soli_id) }}" style="background: #2196F3; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#1976D2'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#2196F3'; this.style.transform='scale(1)';">Ver</a>
                                    
                                    @if($adoption->Soli_estado == 'Pendiente')
                                    <a href="{{ route('admin.adoptions.assign', $adoption->Soli_id) }}" style="background: #FF9800; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#F57C00'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#FF9800'; this.style.transform='scale(1)';">Asignar</a>
                                    @endif
                                    
                                    @if($adoption->Soli_estado == 'En Revisión')
                                    <a href="{{ route('admin.adoptions.approve', $adoption->Soli_id) }}" style="background: #4CAF50; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#388E3C'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#4CAF50'; this.style.transform='scale(1)';">✓</a>
                                    <a href="{{ route('admin.adoptions.reject', $adoption->Soli_id) }}" style="background: #f44336; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#da190b'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#f44336'; this.style.transform='scale(1)';">✕</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div style="background: white; border-radius: 8px; padding: 80px 40px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="font-size: 60px; margin-bottom: 20px;">📋</div>
            <h3 style="color: #666; font-size: 18px; margin: 0 0 10px 0;">No hay solicitudes de adopción</h3>
            <p style="color: #999; font-size: 14px; margin: 0;">Las solicitudes de adopción aparecerán aquí cuando se registren nuevas</p>
        </div>
        @endif
    </div>
</main>

<style>
    @media (max-width: 768px) {
        main {
            padding: 20px 15px !important;
        }
        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
        h1 {
            font-size: 22px !important;
        }
        table {
            font-size: 12px !important;
        }
        td, th {
            padding: 12px !important;
        }
        div[style*="display: flex"] {
            flex-direction: column;
        }
    }
</style>
@endsection
