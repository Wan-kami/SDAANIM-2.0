@extends('layouts.app')

@section('panel-title', 'Historial Médico')

@section('styles')
<style>
    .medical-history-container {
        padding: 0;
    }
</style>
@endsection

@section('content')
<div class="premium-dashboard-container">
    @include('partials.vet_sidebar')

    <main class="dashboard-main-panel">
        <div class="medical-history-container">
            <div class="tasks-page-header">
                <h1>Historial de {{ $animal->Anim_nombre }}</h1>
                <p>{{ $animal->Anim_raza }} • {{ $animal->Anim_edad }}</p>
            </div>

            <!-- INFO DEL ANIMAL -->
            <div class="premium-card" style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px; border-top: 8px solid #20B2AA;">
                <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid #f1f5f9;">
                <div>
                    <h2 style="font-family: 'Pacifico', cursive; color: #1C9F96; margin: 0;">{{ $animal->Anim_nombre }}</h2>
                </div>
            </div>

            <!-- FORMULARIO NUEVO REGISTRO -->
            <div class="premium-card" style="margin-bottom: 50px; border-left: 8px solid #7FFFD4;">
                <h3 style="color: #2c3e50; margin-bottom: 25px;">➕ Nueva Anotación Clínica</h3>
                <form action="{{ route('vet.history.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="Anim_id" value="{{ $animal->Anim_id }}">
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Tipo de Intervención</label>
                            <select name="His_tipo" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;">
                                <option value="Consulta">🩺 Consulta General</option>
                                <option value="Vacuna">💉 Vacunación</option>
                                <option value="Revision">🔍 Revisión de Control</option>
                                <option value="Urgencia">🚨 Urgencia Médica</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Diagnóstico / Motivo</label>
                            <input type="text" name="His_descripcion" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;" placeholder="Ej: Control anual, Dolor abdominal...">
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Tratamiento Sugerido</label>
                        <textarea name="His_tratamiento" style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;" rows="2" placeholder="Medicamentos, dieta, reposo..."></textarea>
                    </div>

                    <button type="submit" class="premium-btn premium-btn-vet" style="padding: 15px 40px; font-size: 1.1em; width: 100%; justify-content: center;">Confirmar Registro Médico 📋</button>
                </form>
            </div>

            <!-- LINEA DE TIEMPO / HISTORIAL -->
            <h3 style="margin-bottom: 30px; color: #334155; display: flex; align-items: center; gap: 10px;">
                <span style="background: #20B2AA; width: 15px; height: 15px; border-radius: 50%;"></span>
                Cronología Clínica
            </h3>
            
            <div style="position: relative; padding-left: 30px; border-left: 3px solid #e2e8f0;">
                @forelse($histories as $history)
                    <div class="premium-card" style="margin-bottom: 25px; position: relative; padding: 25px;">
                        <div style="position: absolute; left: -42px; top: 25px; width: 20px; height: 20px; background: white; border: 4px solid #20B2AA; border-radius: 50%; z-index: 10;"></div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px dashed #e2e8f0; padding-bottom: 10px;">
                            <span style="font-weight: 800; color: #20B2AA; font-size: 0.9em;">📅 {{ \Carbon\Carbon::parse($history->Hist_fecha)->isoFormat('LLLL') }}</span>
                            <span style="background: #f1f5f9; padding: 5px 12px; border-radius: 8px; font-size: 0.8em; font-weight: 700; color: #475569;">👨‍⚕️ Dr. {{ $history->vet->name }}</span>
                        </div>
                        
                        <h4 style="margin: 15px 0 10px 0; color: #1e293b; font-size: 1.2em;">{{ $history->Hist_diagnostico }}</h4>
                        
                        @if($history->Hist_tratamiento)
                            <div style="background: #f8fafc; padding: 15px; border-radius: 12px; border-left: 4px solid #7FFFD4; margin-top: 15px;">
                                <p style="margin: 0; font-size: 0.95em; color: #334155;"><strong>Tratamiento:</strong> {{ $history->Hist_tratamiento }}</p>
                            </div>
                        @endif
                        
                        @if($history->Hist_observaciones)
                            <p style="margin-top: 15px; color: #64748b; font-style: italic; font-size: 0.9em;">
                                <strong>Nota adicional:</strong> {{ $history->Hist_observaciones }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div style="background: #f8fafc; padding: 30px; border-radius: 15px; text-align: center; border: 2px dashed #cbd5e1;">
                        <p style="font-size: 1.2em; color: #64748b; margin: 0;">🏥 Este animal aún no tiene historial médico registrado.</p>
                        <p style="color: #94a3b8; font-size: 0.9em; margin-top: 5px;">Usa el formulario superior para agregar su primera intervención.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
