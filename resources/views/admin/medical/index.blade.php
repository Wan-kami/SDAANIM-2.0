@extends('layouts.app')

@section('content')
<main class="medical-history-page">
    <div class="page-header">
        <a href="{{ route('admin.dashboard') }}" class="back-button">← Volver</a>
        <div>
            <h1>Historial Médico</h1>
            <p class="subtitle">Registros clínicos de los animales, con fechas, diagnóstico y tratamiento asignado.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert success-alert">{{ session('success') }}</div>
    @endif

    @if($histories->count() > 0)
    <div class="table-card">
        <div class="table-meta">
            <span>{{ $histories->count() }} registros encontrados</span>
        </div>
        <table class="medical-history-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Veterinario</th>
                    <th>Fecha</th>
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $history)
                <tr>
                    <td data-label="ID">{{ $history->Hist_id }}</td>
                    <td data-label="Animal">
                        @if($history->animal)
                            <button 
                                onclick="openAnimalMedicalHistory({{ $history->animal->Anim_id }}, this.dataset.animal)"
                                data-animal="{{ json_encode([
                                    'Anim_nombre' => $history->animal->Anim_nombre,
                                    'Anim_foto' => $history->animal->Anim_foto ?? 'placeholder.jpg',
                                    'Anim_raza' => $history->animal->Anim_raza,
                                    'Anim_sexo' => $history->animal->Anim_sexo,
                                    'Anim_edad' => $history->animal->Anim_edad,
                                    'Anim_estado' => $history->animal->Anim_estado,
                                    'Anim_historia' => $history->animal->Anim_historia,
                                ]) }}"
                                style="background: none; border: none; color: #0f5132; text-decoration: underline; cursor: pointer; font-weight: 600; font-size: inherit; padding: 0;">
                                {{ $history->animal->Anim_nombre }}
                            </button>
                        @else
                            N/A
                        @endif
                    </td>
                    <td data-label="Veterinario">{{ $history->veterinarian->name ?? 'N/A' }}</td>
                    <td data-label="Fecha">{{ $history->Hist_fecha ? \Carbon\Carbon::parse($history->Hist_fecha)->format('d/m/Y H:i') : 'N/A' }}</td>
                    <td data-label="Diagnóstico">{{ Str::limit($history->Hist_diagnostico, 70) }}</td>
                    <td data-label="Tratamiento">{{ Str::limit($history->Hist_tratamiento, 70) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state-card">
        <span class="empty-icon">🩺</span>
        <h2>No hay registros aún</h2>
        <p>Aún no se ha registrado historial médico para ningún animal. Agrega un registro para mantener el seguimiento clínico actualizado.</p>
    </div>
    @endif

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
</main>

<style>
    .medical-history-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1.5rem 3rem;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.2rem;
        border-radius: 999px;
        background: #eef7f0;
        color: #166644;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.2s ease, background 0.2s ease;
        box-shadow: 0 8px 20px rgba(12, 80, 55, 0.08);
    }

    .back-button:hover {
        transform: translateY(-1px);
        background: #d9efe2;
    }

    .page-header h1 {
        margin: 0;
        font-size: 2rem;
        letter-spacing: -0.03em;
        color: #0f5132;
    }

    .subtitle {
        margin-top: 0.4rem;
        color: #555;
        line-height: 1.6;
        max-width: 720px;
    }

    .alert {
        padding: 1rem 1.2rem;
        border-radius: 14px;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(15, 73, 43, 0.08);
    }

    .success-alert {
        background: #e8f7ed;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .table-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 1.25rem;
        box-shadow: 0 20px 50px rgba(17, 69, 50, 0.08);
        border: 1px solid rgba(15, 81, 55, 0.08);
    }

    .table-meta {
        display: flex;
        justify-content: flex-end;
        font-size: 0.95rem;
        color: #5f6d7a;
        margin-bottom: 1rem;
    }

    .medical-history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.7rem;
        min-width: 780px;
    }

    .medical-history-table thead tr {
        background: linear-gradient(135deg, #196f54, #0f5132);
        color: white;
        border-radius: 18px;
    }

    .medical-history-table th,
    .medical-history-table td {
        padding: 1rem 1rem;
        text-align: left;
        font-size: 0.95rem;
    }

    .medical-history-table th {
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        font-size: 0.82rem;
    }

    .medical-history-table tbody tr {
        background: #f8faf8;
        border: 1px solid #e5ece2;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .medical-history-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(15, 81, 55, 0.08);
    }

    .medical-history-table tbody tr td {
        border: none;
    }

    .medical-history-table tbody tr td:first-child {
        font-weight: 600;
        color: #0f5132;
    }

    .medical-history-table tbody tr td:nth-child(4) {
        color: #475569;
    }

    .empty-state-card {
        background: #fafbf9;
        border: 1px solid #dbe7dc;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: 0 18px 40px rgba(15, 81, 55, 0.06);
        color: #334155;
    }

    .empty-icon {
        display: inline-flex;
        width: 4rem;
        height: 4rem;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e9f4ed;
        color: #1f6d42;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }

    .empty-state-card h2 {
        margin: 0.4rem 0 0.8rem;
        color: #1f3f49;
        font-size: 1.5rem;
    }

    .empty-state-card p {
        margin: 0;
        color: #546475;
        line-height: 1.7;
    }

    @media (max-width: 980px) {
        .medical-history-table {
            min-width: 100%;
        }
    }

    @media (max-width: 720px) {
        .medical-history-page {
            padding: 1.5rem 1rem 2rem;
        }

        .page-header {
            align-items: flex-start;
        }

        .medical-history-table thead {
            display: none;
        }

        .medical-history-table,
        .medical-history-table tbody,
        .medical-history-table tr,
        .medical-history-table td {
            display: block;
            width: 100%;
        }

        .medical-history-table tr {
            margin-bottom: 1rem;
            background: #ffffff;
            border-radius: 18px;
            padding: 1rem;
        }

        .medical-history-table td {
            padding: 0.75rem 0;
            position: relative;
        }

        .medical-history-table td::before {
            content: attr(data-label);
            display: block;
            font-weight: 700;
            color: #344054;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            font-size: 0.8rem;
        }
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

    /* Modal Styles from public page */
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
        <div class="animal-info-grid">
            <img src="${assetBase}/${animal.Anim_foto}" alt="${animal.Anim_nombre}" class="animal-photo">
            <div class="animal-info-card">
                <div class="animal-meta">
                    <h3>${animal.Anim_nombre}</h3>
                    <p>${animal.Anim_raza} • ${animal.Anim_sexo} • ${animal.Anim_edad}</p>
                    <span class="animal-status">${animal.Anim_estado || 'Estado desconocido'}</span>
                    <p class="animal-story">${animal.Anim_historia ? animal.Anim_historia : 'No hay historia disponible para este animal.'}</p>
                </div>
            </div>
        </div>
        <div class="history-section">
            <h3>Registros del historial</h3>
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
@endsection
