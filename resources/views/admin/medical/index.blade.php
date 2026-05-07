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

    {{-- Contenedor split --}}
    <div class="split-container" id="splitContainer">

        {{-- Panel izquierdo: tabla --}}
        <div class="table-panel" id="tablePanel">
            <div class="table-card">
                <div class="table-meta">
                    <span>{{ $histories->count() }} registros encontrados</span>
                    <span class="hint-text">Haz clic en una fila para ver detalles →</span>
                </div>
                <div class="table-scroll-wrapper">
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
                            <tr class="clickable-row"
                                data-id="{{ $history->Hist_id }}"
                                data-nombre="{{ $history->animal->Anim_nombre ?? 'N/A' }}"
                                data-foto="{{ asset('img/' . ($history->animal->Anim_foto ?? 'placeholder.jpg')) }}"
                                data-raza="{{ $history->animal->Anim_raza ?? '' }}"
                                data-sexo="{{ $history->animal->Anim_sexo ?? '' }}"
                                data-edad="{{ $history->animal->Anim_edad ?? '' }}"
                                data-estado="{{ $history->animal->Anim_estado ?? '' }}"
                                data-historia="{{ $history->animal->Anim_historia ?? '' }}"
                                data-vet="{{ $history->veterinarian->name ?? 'N/A' }}"
                                data-fecha="{{ $history->Hist_fecha ? \Carbon\Carbon::parse($history->Hist_fecha)->format('d/m/Y H:i') : 'N/A' }}"
                                data-diagnostico="{{ $history->Hist_diagnostico ?? 'No especificado' }}"
                                data-tratamiento="{{ $history->Hist_tratamiento ?? 'No especificado' }}"
                                data-observaciones="{{ $history->Hist_observaciones ?? '' }}"
                            >
                                <td data-label="ID">{{ $history->Hist_id }}</td>
                                <td data-label="Animal">
                                    @if($history->animal)
                                        <div class="animal-cell">
                                            <img
                                                src="{{ asset('img/' . ($history->animal->Anim_foto ?? 'placeholder.jpg')) }}"
                                                alt="{{ $history->animal->Anim_nombre }}"
                                                class="animal-thumb"
                                            >
                                            <div class="animal-cell-info">
                                                <span class="animal-cell-name">{{ $history->animal->Anim_nombre }}</span>
                                                <span class="animal-cell-meta">{{ $history->animal->Anim_raza }} · {{ $history->animal->Anim_sexo }} · {{ $history->animal->Anim_edad }}</span>
                                            </div>
                                        </div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td data-label="Veterinario">{{ $history->veterinarian->name ?? 'N/A' }}</td>
                                <td data-label="Fecha">{{ $history->Hist_fecha ? \Carbon\Carbon::parse($history->Hist_fecha)->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td data-label="Diagnóstico">{{ Str::limit($history->Hist_diagnostico, 50) ?? 'No especificado' }}</td>
                                <td data-label="Tratamiento">{{ Str::limit($history->Hist_tratamiento, 50) ?? 'No especificado' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel derecho: detalle --}}
        <div class="detail-panel" id="detailPanel">
            <div class="detail-card">
                <button class="close-detail-btn" id="closeDetailBtn" title="Cerrar detalle">✕</button>

                <div class="detail-animal-header">
                    <img id="detailFoto" src="" alt="" class="detail-animal-photo">
                    <div class="detail-animal-meta">
                        <h2 id="detailNombre"></h2>
                        <p id="detailInfo" class="detail-meta-line"></p>
                        <span id="detailEstado" class="detail-status-badge"></span>
                    </div>
                </div>

                @if(false) {{-- solo para mostrar que puede haber historia --}} @endif
                <div class="detail-story-box" id="detailHistoriaWrap">
                    <p id="detailHistoria" class="detail-story-text"></p>
                </div>

                <div class="detail-divider">
                    <span>📋 Registro Médico #<span id="detailId"></span></span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">📅 Fecha</span>
                        <span class="detail-value" id="detailFecha"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">👨‍⚕️ Veterinario</span>
                        <span class="detail-value" id="detailVet"></span>
                    </div>
                    <div class="detail-item detail-full">
                        <span class="detail-label">🔬 Diagnóstico</span>
                        <span class="detail-value" id="detailDiagnostico"></span>
                    </div>
                    <div class="detail-item detail-full">
                        <span class="detail-label">💊 Tratamiento</span>
                        <span class="detail-value" id="detailTratamiento"></span>
                    </div>
                    <div class="detail-item detail-full" id="detailObsWrap" style="display:none;">
                        <span class="detail-label">📝 Observaciones</span>
                        <span class="detail-value" id="detailObservaciones"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @else
    <div class="empty-state-card">
        <span class="empty-icon">🩺</span>
        <h2>No hay registros aún</h2>
        <p>Aún no se ha registrado historial médico para ningún animal. Agrega un registro para mantener el seguimiento clínico actualizado.</p>
    </div>
    @endif

</main>

<style>
    /* ── PAGE ── */
    .medical-history-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1.5rem 3rem;
    }

    .page-header {
        display: flex;
        align-items: center;
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
        white-space: nowrap;
    }
    .back-button:hover { transform: translateY(-1px); background: #d9efe2; }

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
    }

    .alert { padding: 1rem 1.2rem; border-radius: 14px; margin-bottom: 1.5rem; }
    .success-alert { background: #e8f7ed; color: #155724; border: 1px solid #c3e6cb; }

    /* ── SPLIT CONTAINER ── */
    .split-container {
        display: flex;
        gap: 0;
        align-items: flex-start;
        transition: gap 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── TABLE PANEL ── */
    .table-panel {
        flex: 1 1 100%;
        min-width: 0;
        transition: flex 0.45s cubic-bezier(0.4, 0, 0.2, 1),
                    transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: flex, transform;
    }

    .split-container.panel-open .table-panel {
        flex: 0 0 46%;
        transform: translateX(0);
    }

    .split-container.panel-open {
        gap: 1.2rem;
    }

    .table-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 1.25rem;
        box-shadow: 0 20px 50px rgba(17, 69, 50, 0.08);
        border: 1px solid rgba(15, 81, 55, 0.08);
        overflow: hidden;
    }

    .table-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: #5f6d7a;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .hint-text {
        font-size: 0.8rem;
        color: #94a3b8;
        font-style: italic;
        transition: opacity 0.3s;
    }

    .split-container.panel-open .hint-text {
        opacity: 0;
        pointer-events: none;
    }

    .table-scroll-wrapper {
        overflow-x: auto;
    }

    .medical-history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.55rem;
        min-width: 520px;
    }

    .medical-history-table thead tr {
        background: linear-gradient(135deg, #196f54, #0f5132);
        color: white;
        border-radius: 14px;
    }

    .medical-history-table th,
    .medical-history-table td {
        padding: 0.85rem 0.9rem;
        text-align: left;
        font-size: 0.88rem;
    }

    .medical-history-table th {
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        font-size: 0.76rem;
    }

    .medical-history-table tbody tr {
        background: #f8faf8;
        border: 1px solid #e5ece2;
        border-radius: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        cursor: pointer;
    }

    .medical-history-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(15, 81, 55, 0.1);
        background: #f0f9f3;
    }

    .medical-history-table tbody tr.row-active {
        background: #e6f4ec;
        box-shadow: 0 0 0 2px #1e7e34, 0 8px 24px rgba(15, 81, 55, 0.14);
        transform: translateY(-2px);
    }

    .medical-history-table tbody tr td { border: none; }
    .medical-history-table tbody tr td:first-child { font-weight: 600; color: #0f5132; }
    .medical-history-table tbody tr td:nth-child(4) { color: #475569; }

    /* ── DETAIL PANEL ── */
    .detail-panel {
        flex: 0 0 0%;
        overflow: hidden;
        opacity: 0;
        pointer-events: none;
        transition: flex 0.45s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.35s ease 0.1s;
        will-change: flex, opacity;
    }

    .split-container.panel-open .detail-panel {
        flex: 0 0 54%;
        opacity: 1;
        pointer-events: auto;
    }

    .detail-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 1.8rem;
        box-shadow: 0 20px 50px rgba(17, 69, 50, 0.1);
        border: 1px solid rgba(15, 81, 55, 0.1);
        position: relative;
        min-height: 340px;
        animation: slideInRight 0.38s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .close-detail-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 34px;
        height: 34px;
        background: #f1f5f9;
        border: none;
        border-radius: 50%;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: background 0.2s, color 0.2s;
        line-height: 1;
    }
    .close-detail-btn:hover { background: #fee2e2; color: #dc2626; }

    /* Animal header */
    .detail-animal-header {
        display: flex;
        gap: 1.2rem;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9f0ea;
    }

    .detail-animal-photo {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 18px;
        border: 3px solid #d2eedd;
        box-shadow: 0 10px 28px rgba(15, 81, 55, 0.12);
        flex-shrink: 0;
    }

    .detail-animal-meta {
        flex: 1;
        min-width: 0;
    }

    .detail-animal-meta h2 {
        margin: 0 0 0.3rem;
        font-size: 1.4rem;
        color: #0f5132;
        font-weight: 800;
    }

    .detail-meta-line {
        margin: 0 0 0.5rem;
        color: #64748b;
        font-size: 0.9rem;
    }

    .detail-status-badge {
        display: inline-flex;
        align-items: center;
        background: #e8f7ed;
        color: #166644;
        font-weight: 700;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        font-size: 0.82rem;
    }

    /* Historia */
    .detail-story-box {
        background: #f8faf8;
        border-left: 3px solid #34d399;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
    }
    .detail-story-text {
        margin: 0;
        color: #475569;
        font-size: 0.88rem;
        line-height: 1.7;
    }

    /* Divider */
    .detail-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: #0f5132;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .detail-divider::before,
    .detail-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, #d2eedd, transparent);
    }
    .detail-divider::after {
        background: linear-gradient(90deg, transparent, #d2eedd);
    }

    /* Grid de datos */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .detail-item {
        background: #f8faf8;
        border-radius: 14px;
        padding: 0.9rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        border: 1px solid #e5ece2;
    }

    .detail-full {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
    }

    .detail-value {
        font-size: 0.95rem;
        color: #1e293b;
        line-height: 1.6;
        font-weight: 500;
    }

    /* ── ANIMAL CELL IN TABLE ── */
    .animal-cell { display: flex; align-items: center; gap: 8px; }
    .animal-thumb {
        width: 38px; height: 38px;
        object-fit: cover;
        border-radius: 9px;
        border: 2px solid #d9f2e4;
        flex-shrink: 0;
    }
    .animal-cell-info { display: flex; flex-direction: column; gap: 1px; }
    .animal-cell-name { font-weight: 700; color: #0f5132; font-size: 0.88rem; }
    .animal-cell-meta { font-size: 0.73rem; color: #64748b; }

    /* ── EMPTY STATE ── */
    .empty-state-card {
        background: #fafbf9; border: 1px solid #dbe7dc; border-radius: 24px;
        padding: 2.5rem 2rem; text-align: center;
        box-shadow: 0 18px 40px rgba(15, 81, 55, 0.06); color: #334155;
    }
    .empty-icon {
        display: inline-flex; width: 4rem; height: 4rem;
        align-items: center; justify-content: center;
        border-radius: 50%; background: #e9f4ed; color: #1f6d42;
        font-size: 1.8rem; margin-bottom: 1rem;
    }
    .empty-state-card h2 { margin: 0.4rem 0 0.8rem; color: #1f3f49; font-size: 1.5rem; }
    .empty-state-card p  { margin: 0; color: #546475; line-height: 1.7; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .split-container.panel-open { flex-direction: column; gap: 1rem; }
        .split-container.panel-open .table-panel,
        .split-container.panel-open .detail-panel {
            flex: 1 1 100% !important;
        }
    }

    @media (max-width: 720px) {
        .medical-history-table { min-width: 100%; }
        .medical-history-table thead { display: none; }
        .medical-history-table,
        .medical-history-table tbody,
        .medical-history-table tr,
        .medical-history-table td { display: block; width: 100%; }
        .medical-history-table tr { margin-bottom: 1rem; border-radius: 18px; padding: 1rem; }
        .medical-history-table td { padding: 0.6rem 0; }
        .medical-history-table td::before {
            content: attr(data-label);
            display: block;
            font-weight: 700; color: #344054;
            margin-bottom: 0.3rem;
            text-transform: uppercase; letter-spacing: 0.02em; font-size: 0.78rem;
        }
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>

<script>
(function () {
    const container   = document.getElementById('splitContainer');
    const detailPanel = document.getElementById('detailPanel');
    const closeBtn    = document.getElementById('closeDetailBtn');
    let activeRow     = null;

    // ── Campos del panel derecho ──
    const fields = {
        foto:         document.getElementById('detailFoto'),
        nombre:       document.getElementById('detailNombre'),
        info:         document.getElementById('detailInfo'),
        estado:       document.getElementById('detailEstado'),
        historia:     document.getElementById('detailHistoria'),
        historiaWrap: document.getElementById('detailHistoriaWrap'),
        id:           document.getElementById('detailId'),
        fecha:        document.getElementById('detailFecha'),
        vet:          document.getElementById('detailVet'),
        diagnostico:  document.getElementById('detailDiagnostico'),
        tratamiento:  document.getElementById('detailTratamiento'),
        observaciones:document.getElementById('detailObservaciones'),
        obsWrap:      document.getElementById('detailObsWrap'),
    };

    function openDetail(row) {
        const d = row.dataset;

        // Foto y nombre
        fields.foto.src = d.foto;
        fields.foto.alt = d.nombre;
        fields.nombre.textContent = d.nombre;
        fields.info.textContent   = [d.raza, d.sexo, d.edad].filter(Boolean).join(' · ');
        fields.estado.textContent = d.estado || 'Sin estado';

        // Historia
        if (d.historia && d.historia.trim()) {
            fields.historia.textContent     = d.historia;
            fields.historiaWrap.style.display = '';
        } else {
            fields.historiaWrap.style.display = 'none';
        }

        // Registro médico
        fields.id.textContent          = d.id;
        fields.fecha.textContent        = d.fecha;
        fields.vet.textContent          = d.vet;
        fields.diagnostico.textContent  = d.diagnostico;
        fields.tratamiento.textContent  = d.tratamiento;

        // Observaciones (opcional)
        if (d.observaciones && d.observaciones.trim()) {
            fields.observaciones.textContent = d.observaciones;
            fields.obsWrap.style.display     = '';
        } else {
            fields.obsWrap.style.display = 'none';
        }

        // Activar fila
        if (activeRow) activeRow.classList.remove('row-active');
        row.classList.add('row-active');
        activeRow = row;

        // Abrir split
        container.classList.add('panel-open');

        // Re-animar el card
        const card = detailPanel.querySelector('.detail-card');
        card.style.animation = 'none';
        void card.offsetWidth; // reflow
        card.style.animation = '';
    }

    function closeDetail() {
        container.classList.remove('panel-open');
        if (activeRow) {
            activeRow.classList.remove('row-active');
            activeRow = null;
        }
    }

    // Click en filas
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', () => {
            if (row === activeRow) {
                closeDetail();
            } else {
                openDetail(row);
            }
        });
    });

    // Botón cerrar
    closeBtn.addEventListener('click', closeDetail);

    // Tecla Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDetail();
    });
})();
</script>
@endsection
