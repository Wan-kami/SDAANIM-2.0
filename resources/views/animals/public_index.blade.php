@extends('layouts.adopter.app')

@section('title', 'Adopta un Amigo')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/adopter/animals.css') }}">
@endsection

@section('content')
<section class="adopta-section">
    <h1 style="color: #2e8b57; margin-bottom: 10px; font-weight: 800;">
        Adopta un Amigo 🐾
    </h1>

    <p style="color: #64748b; margin-bottom: 40px;">
        Encuentra el compañero perfecto para tu hogar.
    </p>

    <!-- FILTROS -->
    <div class="adopta-filtros">
        <a href="{{ route('adopta', ['etapa' => 'todos']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'todos' ? 'activo' : '' }}">
           Todos
        </a>

        <a href="{{ route('adopta', ['etapa' => 'cachorro']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'cachorro' ? 'activo' : '' }}">
           Cachorros
        </a>

        <a href="{{ route('adopta', ['etapa' => 'joven']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'joven' ? 'activo' : '' }}">
           Jóvenes
        </a>

        <a href="{{ route('adopta', ['etapa' => 'adulto']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'adulto' ? 'activo' : '' }}">
           Adultos
        </a>
    </div>

    <!-- CARDS -->
    <div class="premium-grid">
        @forelse($animals as $animal)
            <div class="premium-card">
                <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" 
                     alt="{{ $animal->Anim_nombre }}">

                <div>
                    <h3>{{ $animal->Anim_nombre }}</h3>

                    <p>
                        {{ $animal->Anim_raza }} • {{ $animal->Anim_sexo }} <br>
                        {{ $animal->Anim_edad }}
                    </p>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ route('adopter.adoption.create', $animal->Anim_id) }}" 
                           class="premium-btn-adopter" style="flex: 1; text-align: center;">
                            ¡Quiero Adoptarlo! ❤️
                        </a>
                        <button
                            onclick="openAnimalMedicalHistory({{ $animal->Anim_id }}, this.dataset.animal)"
                            data-animal="{{ json_encode([
                                'Anim_nombre' => $animal->Anim_nombre,
                                'Anim_foto' => $animal->Anim_foto ?? 'placeholder.jpg',
                                'Anim_raza' => $animal->Anim_raza,
                                'Anim_sexo' => $animal->Anim_sexo,
                                'Anim_edad' => $animal->Anim_edad,
                                'Anim_estado' => $animal->Anim_estado,
                                'Anim_historia' => $animal->Anim_historia,
                            ]) }}"
                            style="background: #e8f5e9; color: #1e7e34; border: 2px solid #1e7e34; padding: 8px 12px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; white-space: nowrap;">
                            📋 Historial
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="no-animals">
                No hay peluditos disponibles por ahora 🐾
            </p>
        @endforelse
    </div>

    <!-- Modal para Historial Médico del Animal -->
    <div id="animalMedicalHistoryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 12px; max-width: 700px; width: 90%; max-height: 80vh; overflow-y: auto; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 id="animalModalTitle" style="margin: 0; color: #1e7e34;">📋 Historial Médico</h2>
            <button onclick="closeAnimalMedicalHistory()" style="background: #e2e8f0; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
        </div>

        <div id="animalMedicalHistoryContent" style="text-align: center;">
            <p style="color: #64748b;">Cargando historial médico...</p>
        </div>

        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0; text-align: right;">
            <button onclick="closeAnimalMedicalHistory()" style="background: #1e7e34; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<style>
    .animal-info-grid {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 20px;
        align-items: center;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .animal-info-card {
        display: flex;
        flex-direction: column;
        gap: 12px;
        text-align: left;
    }

    .animal-photo {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 18px;
        border: 2px solid #d9f2e4;
        box-shadow: 0 14px 35px rgba(15, 81, 55, 0.08);
    }

    .animal-meta h3 {
        margin: 0;
        font-size: 1.65rem;
        color: #13432c;
    }

    .animal-meta p,
    .animal-meta .animal-status {
        margin: 0;
        color: #475569;
        line-height: 1.5;
    }

    .animal-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 10px;
        background: #e8f7ed;
        color: #166644;
        font-weight: 600;
        padding: 0.45rem 0.85rem;
        border-radius: 999px;
        font-size: 0.9rem;
    }

    .animal-story {
        margin-top: 12px;
        color: #334155;
        line-height: 1.75;
    }

    .history-section {
        margin-top: 1.5rem;
        text-align: left;
    }

    .history-section h3 {
        margin: 0 0 16px;
        color: #0f5132;
        font-size: 1.3rem;
    }

    .history-card {
        background: #f8faf8;
        padding: 18px;
        border-radius: 16px;
        border-left: 4px solid #1e7e34;
        margin-bottom: 16px;
        box-shadow: 0 8px 22px rgba(15, 81, 55, 0.06);
    }

    .history-card p {
        margin: 8px 0;
        color: #27303b;
        line-height: 1.7;
    }

    .history-card p span {
        font-weight: 700;
        color: #0f5132;
    }

    @media (max-width: 720px) {
        .animal-info-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .animal-info-grid img {
            margin: 0 auto;
        }

        .animal-meta {
            align-items: center;
        }
    }
</style>

<script>
function openAnimalMedicalHistory(animalId, animalJson) {
    const modal = document.getElementById('animalMedicalHistoryModal');
    const titleEl = document.getElementById('animalModalTitle');
    const contentEl = document.getElementById('animalMedicalHistoryContent');
    const assetBase = '{{ asset('img/') }}';
    const animal = typeof animalJson === 'string' ? JSON.parse(animalJson) : animalJson;

    titleEl.textContent = '📋 Historial Médico - ' + animal.Anim_nombre;
    contentEl.innerHTML = `
        <div class="history-section" style="margin-top: 0;">
            <h3 style="margin-top: 0;">Registros del historial</h3>
            <div id="animalHistoryRecords">
                <p style="color: #64748b;">Cargando historial médico...</p>
            </div>
        </div>
    `;

    fetch(`/api/animal/${animalId}/medical-history`)
        .then(response => response.json())
        .then(data => {
            const historyRecords = document.getElementById('animalHistoryRecords');
            if (data.histories && data.histories.length > 0) {
                let html = '';
                data.histories.forEach(history => {
                    html += `
                        <div class="history-card">
                            <p><span>Fecha:</span> ${history.fecha}</p>
                            <p><span>Veterinario:</span> ${history.vet}</p>
                            <p><span>Diagnóstico:</span> ${history.diagnostico || 'No especificado'}</p>
                            <p><span>Tratamiento:</span> ${history.tratamiento || 'No especificado'}</p>
                            ${history.observaciones ? `<p><span>Observaciones:</span> ${history.observaciones}</p>` : ''}
                        </div>
                    `;
                });
                historyRecords.innerHTML = html;
            } else {
                historyRecords.innerHTML = `
                    <div style="text-align: center; padding: 30px 20px; color: #64748b;">
                        <p style="font-size: 16px; margin-bottom: 10px;">No hay registros de historial médico disponibles.</p>
                        <p style="font-size: 14px;">Este animal aún no tiene historial clínico registrado.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('animalHistoryRecords').innerHTML = '<p style="color: #e53e3e; text-align: center;">Error al cargar el historial médico. Por favor, intenta nuevamente.</p>';
        });

    modal.style.display = 'flex';
}

function closeAnimalMedicalHistory() {
    document.getElementById('animalMedicalHistoryModal').style.display = 'none';
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('animalMedicalHistoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAnimalMedicalHistory();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAnimalMedicalHistory();
    }
});
</script>
</section>
@endsection