@extends('layouts.app')

@section('content')
<main style="padding: 40px 20px; background: #f5f5f5; min-height: 100vh;">
    <div style="max-width: 700px; margin: 0 auto;">
        <!-- Back Button -->
        <a href="{{ route('admin.adoptions') }}" style="display: inline-block; width: 45px; height: 45px; border-radius: 50%; background: #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 30px; transition: all 0.3s; text-decoration: none; color: #333;" onmouseover="this.style.background='#2e8b57'; this.style.color='white';" onmouseout="this.style.background='#e8e8e8'; this.style.color='#333';">←</a>

        <!-- Header Card -->
        <div style="background: linear-gradient(135deg, #2e8b57 0%, #4caf50 100%); border-radius: 8px; padding: 30px; color: white; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 10px 0; font-size: 28px; font-weight: 600;">📋 Registrar Seguimiento</h1>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Solicitud #{{ $adoption->Soli_id }} - {{ $adoption->animal->Anim_nombre ?? 'Animal' }}</p>
        </div>

        <!-- Form Card -->
        <div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <form action="{{ route('admin.adoptions.followup.store', $adoption->Soli_id) }}" method="POST">
                @csrf

                <!-- Tipo de Seguimiento -->
                <div style="margin-bottom: 25px;">
                    <label for="Segui_tipo" style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">Tipo de Seguimiento *</label>
                    <select name="Segui_tipo" id="Segui_tipo" required style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px; font-family: inherit; transition: all 0.3s; cursor: pointer;" onfocus="this.style.borderColor='#2e8b57'; this.style.boxShadow='0 0 0 3px rgba(46, 139, 87, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                        <option value="">-- Seleccionar --</option>
                        <option value="Entrevista">📞 Entrevista</option>
                        <option value="Visita">🏠 Visita</option>
                        <option value="Pos_visita">✓ Pos-visita</option>
                    </select>
                </div>

                <!-- Estado -->
                <div style="margin-bottom: 25px;">
                    <label for="Segui_estado" style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">Estado *</label>
                    <select name="Segui_estado" id="Segui_estado" required style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px; font-family: inherit; transition: all 0.3s; cursor: pointer;" onfocus="this.style.borderColor='#2e8b57'; this.style.boxShadow='0 0 0 3px rgba(46, 139, 87, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                        <option value="Pendiente">⏳ Pendiente</option>
                        <option value="En proceso">🔄 En proceso</option>
                        <option value="Aprobada">✓ Aprobada</option>
                        <option value="Rechazada">✕ Rechazada</option>
                    </select>
                </div>

                <!-- Fecha -->
                <div style="margin-bottom: 25px;">
                    <label for="Segui_fecha" style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">Fecha de Seguimiento</label>
                    <input type="date" name="Segui_fecha" id="Segui_fecha" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px; font-family: inherit; transition: all 0.3s;" onfocus="this.style.borderColor='#2e8b57'; this.style.boxShadow='0 0 0 3px rgba(46, 139, 87, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                </div>

                <!-- Descripción -->
                <div style="margin-bottom: 25px;">
                    <label for="Segui_descripcion" style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">Descripción / Informe</label>
                    <textarea name="Segui_descripcion" id="Segui_descripcion" rows="6" placeholder="Ingrese los detalles del seguimiento..." style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px; font-family: inherit; transition: all 0.3s; resize: vertical;" onfocus="this.style.borderColor='#2e8b57'; this.style.boxShadow='0 0 0 3px rgba(46, 139, 87, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';"></textarea>
                </div>

                <!-- Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <a href="{{ route('admin.adoptions') }}" style="background: #e0e0e0; color: #333; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.3s;" onmouseover="this.style.background='#d0d0d0'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#e0e0e0'; this.style.transform='translateY(0)';">Cancelar</a>
                    <button type="submit" style="background: #2e8b57; color: white; padding: 12px 20px; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#1e6a3e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(46, 139, 87, 0.3)';" onmouseout="this.style.background='#2e8b57'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">💾 Guardar Seguimiento</button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div style="background: white; border-radius: 8px; padding: 20px; margin-top: 20px; border-left: 4px solid #FF9800; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <p style="margin: 0; color: #555; font-size: 13px; line-height: 1.6;">
                <strong style="color: #FF9800;">⚠️ Importante:</strong> Completa todos los campos requeridos para registrar el seguimiento de esta solicitud de adopción.
            </p>
        </div>
    </div>
</main>

<style>
    @media (max-width: 768px) {
        main {
            padding: 20px 15px !important;
        }
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        h1 {
            font-size: 22px !important;
        }
    }
</style>
@endsection
