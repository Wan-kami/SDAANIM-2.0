@extends('layouts.app')

@section('content')
<div class="tasks-container">
    <!-- Header Section -->
    <div class="tasks-header-wrapper">
        <div class="tasks-header">
            <div class="header-content">
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
                    <span class="back-icon">←</span>
                </a>
                <div>
                    <h1>📊 Gestión de Tareas</h1>
                    <p class="subtitle">Crea, organiza y monitorea las tareas del sistema</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.tasks.create') }}" class="btn-create">
                    <span class="btn-icon">+</span> Nueva Tarea
                </a>
                <a href="{{ route('admin.tasks.createAdoption') }}" class="btn-create btn-adoption">
                    <span class="btn-icon">🐕</span> Tarea de Adopción
                </a>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">✅</div>
        <div class="alert-content">
            <strong>¡Éxito!</strong>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Tasks Table Card -->
    @if($tasks->count() > 0)
    <div class="table-card">
        <table class="tasks-table">
            <thead>
                <tr>
                    <th class="col-id">#ID</th>
                    <th class="col-title">Título</th>
                    <th class="col-assigned">Asignado a</th>
                    <th class="col-date">Fecha Límite</th>
                    <th class="col-status">Estado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr class="task-row">
                    <td class="col-id"><span class="task-id">#{{ $task->Tar_id }}</span></td>
                    <td class="col-title">
                        <div class="task-title-cell">
                            <strong>{{ $task->Tar_titulo }}</strong>
                        </div>
                    </td>
                    <td class="col-assigned">
                        <div class="user-badge">
                            <span class="avatar">{{ substr($task->user->name ?? 'N/A', 0, 1) }}</span>
                            <span class="name">{{ $task->user->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="col-date">
                        <span class="date-badge">{{ \Carbon\Carbon::parse($task->Tar_fecha_limite)->format('d/m/Y') }}</span>
                    </td>
                    <td class="col-status">
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $task->Tar_estado)) }}">
                            {{ $task->Tar_estado }}
                        </span>
                    </td>
                    <td class="col-actions">
                        <button type="button" class="btn-action btn-view btn-view-task" 
                                data-id="{{ $task->Tar_id }}"
                                data-title="{{ $task->Tar_titulo }}"
                                data-desc="{{ $task->Tar_descripcion }}"
                                data-user="{{ $task->user->name ?? 'N/A' }}"
                                data-date="{{ \Carbon\Carbon::parse($task->Tar_fecha_limite)->format('d/m/Y') }}"
                                data-status="{{ $task->Tar_estado }}"
                                data-comment="{{ $task->Tar_comentario ?? 'Sin comentarios' }}"
                                title="Ver detalles">
                            <span>👁️</span> Ver
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">📋</div>
        <h3>No hay tareas registradas</h3>
        <p>Crea una nueva tarea para comenzar a organizar el trabajo de tu fundación.</p>
        <a href="{{ route('admin.tasks.create') }}" class="btn-create">
            <span class="btn-icon">+</span> Crear Primera Tarea
        </a>
    </div>
    @endif
</div>

<style>
    .tasks-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header Styles */
    .tasks-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 0;
        flex: 1;
    }

    .header-content h1 {
        font-size: 2rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    /* Create Button */
    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-adoption {
        background: linear-gradient(135deg, #2196F3, #1976D2);
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
    }

    .btn-adoption:hover {
        box-shadow: 0 6px 25px rgba(33, 150, 243, 0.3);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(76, 175, 80, 0.3);
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 50%;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 1rem;
        font-size: 1.2rem;
        border: 2px solid #e0e0e0;
    }

    .btn-back:hover {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: scale(1.1);
    }

    .back-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Header Wrapper */
    .tasks-header-wrapper {
        margin-bottom: 2rem;
    }

    .btn-icon {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Success Alert */
    .alert {
        margin-bottom: 2rem;
        padding: 1.2rem;
        border-radius: 12px;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        animation: slideInDown 0.4s ease;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #e8f5e9;
        border-left: 5px solid #4caf50;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.15);
    }

    .alert-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .alert-content strong {
        color: #2e7d32;
        display: block;
        margin-bottom: 0.3rem;
    }

    .alert-content p {
        color: #558b2f;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    /* Table Styles */
    .tasks-table {
        width: 100%;
        border-collapse: collapse;
    }

    .tasks-table thead {
        background: linear-gradient(135deg, #f8fbf8 0%, #f0f8f0 100%);
        border-bottom: 2px solid #e0e0e0;
    }

    .tasks-table th {
        padding: 1.2rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .col-id { width: 70px; }
    .col-title { flex: 1; }
    .col-assigned { width: 180px; }
    .col-date { width: 140px; }
    .col-status { width: 150px; }
    .col-actions { width: 120px; text-align: center; }

    .task-row {
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s ease;
    }

    .task-row:hover {
        background-color: #f9faf9;
    }

    .tasks-table td {
        padding: 1rem 1.2rem;
        vertical-align: middle;
    }

    .task-id {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .task-title-cell {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .task-title-cell strong {
        color: #1a1a1a;
    }

    /* User Badge */
    .user-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4CAF50, #81C784);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .user-badge .name {
        font-weight: 500;
        color: #333;
    }

    /* Date Badge */
    .date-badge {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Status Select */
    .status-form {
        display: inline;
    }

    .status-select {
        padding: 0.5rem 0.8rem;
        border: 2px solid #f0f0f0;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        background-color: white;
    }

    .status-select:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
        text-align: center;
        min-width: 100px;
    }

    .status-pendiente { background-color: #fff8e1; color: #f57c00; border: 1px solid #ffe082; }
    .status-en-proceso { background-color: #e3f2fd; color: #1976d2; border: 1px solid #bbdefb; }
    .status-observación { background-color: #fce4ec; color: #c2185b; border: 1px solid #f8bbd0; }
    .status-completado { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }

    /* Action Buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        background: #f0f0f0;
        color: #667;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-view:hover {
        background: #4CAF50;
        color: white;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.3rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
    }

    .empty-state p {
        color: #666;
        margin: 0 0 1.5rem 0;
        font-size: 0.95rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tasks-container {
            padding: 1rem;
        }

        .tasks-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-content {
            width: 100%;
        }

        .header-content h1 {
            font-size: 1.5rem;
        }

        .btn-back {
            margin-right: 0.5rem;
        }

        .col-title { display: none; }
        .col-assigned { display: none; }

        .task-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
            padding: 1rem 0;
        }

        .tasks-table thead {
            display: none;
        }

        .tasks-table td {
            display: block;
            text-align: right;
            padding: 0.5rem 0;
            border-bottom: none;
        }

        .tasks-table td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
        }
    }
</style>
<!-- Details Modal -->
<div id="taskModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Detalles de la Tarea</h2>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body">
            <div class="detail-group">
                <label>📋 Título</label>
                <p id="detailTitle" class="detail-value"></p>
            </div>
            <div class="detail-row">
                <div class="detail-group">
                    <label>👤 Asignado a</label>
                    <p id="detailUser" class="detail-value"></p>
                </div>
                <div class="detail-group">
                    <label>📅 Fecha Límite</label>
                    <p id="detailDate" class="detail-value"></p>
                </div>
            </div>
            <div class="detail-group">
                <label>📌 Estado Actual</label>
                <p id="detailStatus" class="detail-value"></p>
            </div>
            <div class="detail-group">
                <label>📄 Descripción Completa</label>
                <div id="detailDesc" class="detail-text-box"></div>
            </div>
            <div class="detail-group" id="commentGroup">
                <label>💬 Comentario/Reporte</label>
                <div id="detailComment" class="detail-text-box comment-box"></div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="modal-actions-review" id="reviewActions" style="display: none;">
                <form id="completeTaskForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="Tar_estado" value="Completado">
                    <button type="submit" class="btn-complete-task">
                        ✅ Marcar como Completado
                    </button>
                </form>
            </div>
            <button class="btn-secondary-modal" onclick="closeModal()">Cerrar</button>
        </div>
    </div>
</div>

<style>
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 600px;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        overflow: hidden;
        animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-header {
        padding: 1.5rem 2rem;
        background: #4CAF50;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
    }

    .modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .modal-close:hover {
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 2rem;
        max-height: 70vh;
        overflow-y: auto;
    }

    .detail-group {
        margin-bottom: 1.5rem;
    }

    .detail-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 1.1rem;
        color: #1a1a1a;
        margin: 0;
        font-weight: 600;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .detail-text-box {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        font-size: 0.95rem;
        line-height: 1.6;
        color: #444;
        white-space: pre-wrap;
    }

    .comment-box {
        background: #fff8e1;
        border-color: #ffe082;
        color: #795548;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn-complete-task {
        background: #2e7d32;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
    }

    .btn-complete-task:hover {
        background: #1b5e20;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(46, 125, 50, 0.3);
    }

    .btn-secondary-modal {
        background: #e0e0e0;
        color: #333;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<script>
    function openModal(data) {
        document.getElementById('detailTitle').innerText = data.title;
        document.getElementById('detailUser').innerText = data.user;
        document.getElementById('detailDate').innerText = data.date;
        document.getElementById('detailStatus').innerText = data.status;
        document.getElementById('detailDesc').innerText = data.desc;
        document.getElementById('detailComment').innerText = data.comment;

        // Mostrar acciones de revisión solo si no está completada
        const reviewActions = document.getElementById('reviewActions');
        if (data.status !== 'Completado') {
            reviewActions.style.display = 'block';
            // Configurar la URL del formulario dinámicamente
            const form = document.getElementById('completeTaskForm');
            form.action = `/admin/tasks/${data.id}/status`;
        } else {
            reviewActions.style.display = 'none';
        }
        
        document.getElementById('taskModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('taskModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.btn-view-task');
        viewButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const data = {
                    id: this.dataset.id,
                    title: this.dataset.title,
                    desc: this.dataset.desc,
                    user: this.dataset.user,
                    date: this.dataset.date,
                    status: this.dataset.status,
                    comment: this.dataset.comment
                };
                openModal(data);
            });
        });

        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        // Close on outside click
        document.getElementById('taskModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    });
</script>
@endsection
