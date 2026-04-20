@extends('layouts.app')

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
                            <td style="padding: 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('admin.adoptions.show', $adoption->Soli_id) }}" style="background: #2196F3; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#1976D2'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#2196F3'; this.style.transform='scale(1)';">Ver</a>
                                    
                                    @if($adoption->Soli_estado == 'Pendiente')
                                    <a href="{{ route('admin.adoptions.assign', $adoption->Soli_id) }}" style="background: #FF9800; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#F57C00'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#FF9800'; this.style.transform='scale(1)';">Asignar</a>
                                    @endif
                                    
                                    @if($adoption->Soli_estado == 'En Revisión' && $adoption->followups && $adoption->followups->count() > 0)
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
