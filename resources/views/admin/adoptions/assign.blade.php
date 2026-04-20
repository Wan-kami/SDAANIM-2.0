@extends('layouts.app')

@section('content')
<main style="padding: 40px 20px; background: #f5f5f5; min-height: 100vh;">
    <div style="max-width: 600px; margin: 0 auto;">
        <!-- Back Button -->
        <a href="{{ route('admin.adoptions') }}" style="display: inline-block; width: 45px; height: 45px; border-radius: 50%; background: #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 30px; transition: all 0.3s; text-decoration: none; color: #333;" onmouseover="this.style.background='#2e8b57'; this.style.color='white';" onmouseout="this.style.background='#e8e8e8'; this.style.color='#333';">←</a>

        <!-- Header Card -->
        <div style="background: linear-gradient(135deg, #2e8b57 0%, #4caf50 100%); border-radius: 8px; padding: 30px; color: white; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 10px 0; font-size: 28px; font-weight: 600;">👤 Asignar Voluntario</h1>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Selecciona un voluntario para revisar esta solicitud de adopción</p>
        </div>

        <!-- Form Card -->
        <div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <form action="{{ route('admin.adoptions.assign.store') }}" method="POST">
                @csrf
                <input type="hidden" name="Soli_id" value="{{ $adoptionId }}">

                <div style="margin-bottom: 25px;">
                    <label for="vol_id" style="display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 14px;">Seleccionar Voluntario *</label>
                    <select name="vol_id" id="vol_id" required style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px; font-family: inherit; transition: all 0.3s; cursor: pointer;" onchange="this.style.borderColor='#2e8b57';" onfocus="this.style.borderColor='#2e8b57'; this.style.boxShadow='0 0 0 3px rgba(46, 139, 87, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                        <option value="">-- Seleccione un voluntario --</option>
                        @forelse($volunteers as $vol)
                        <option value="{{ $vol->Usu_documento }}">{{ $vol->name }}</option>
                        @empty
                        <option disabled>No hay voluntarios registrados</option>
                        @endforelse
                    </select>
                    @if($volunteers->count() === 0)
                    <p style="color: #FF9800; font-size: 13px; margin-top: 10px; padding: 10px; background: #fff3e0; border-radius: 4px;">⚠️ No hay voluntarios disponibles en el sistema</p>
                    @endif
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <a href="{{ route('admin.adoptions') }}" style="background: #e0e0e0; color: #333; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.3s;" onmouseover="this.style.background='#d0d0d0'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#e0e0e0'; this.style.transform='translateY(0)';">Cancelar</a>
                    <button type="submit" style="background: #2e8b57; color: white; padding: 12px 20px; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#1e6a3e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(46, 139, 87, 0.3)';" onmouseout="this.style.background='#2e8b57'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">✓ Asignar Voluntario</button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div style="background: white; border-radius: 8px; padding: 20px; margin-top: 20px; border-left: 4px solid #2196F3; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <p style="margin: 0; color: #555; font-size: 13px; line-height: 1.6;">
                <strong style="color: #2196F3;">ℹ️ Nota:</strong> Al asignar un voluntario, la solicitud cambiará a estado "En Revisión" y el voluntario podrá realizar el seguimiento correspondiente.
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
