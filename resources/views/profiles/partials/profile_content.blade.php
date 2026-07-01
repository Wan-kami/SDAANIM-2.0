<!-- Professional Profile Container -->
<div class="profile-premium-card">
    
    <!-- Professional Back Button -->
    <a href="{{ route('dashboard') }}" class="btn-back-professional" title="Volver al panel">
        <span class="icon">←</span>
        <span class="text">Volver</span>
    </a>

    <!-- Header / Avatar Section -->
    <div class="profile-header-main">
        <div class="avatar-container">
            <img src="{{ $user->Usu_foto ? asset('img/profiles/' . $user->Usu_foto) . '?v=' . time() : asset('img/default-avatar.png') }}" class="main-avatar" onclick="abrirModalFoto(this)" title="Haz clic para ampliar">
            <button onclick="togglePhotoSection()" class="btn-edit-avatar" title="Cambiar foto de perfil">
                <span class="icon">📷</span>
            </button>
        </div>
        <h2 class="profile-name">{{ $user->name }}</h2>
        <div class="profile-role-badge">
            <span class="role-text">{{ $user->role }}</span>
            <span class="divider"></span>
            <span class="status-dot {{ strtolower($user->status) }}"></span>
            <span class="status-text">{{ $user->status }}</span>
        </div>
    </div>

    <!-- Feedback Messages -->
    @if(session('success'))
        <div class="profile-alert success">
            <span class="icon">✅</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="profile-alert error">
            <span class="icon">⚠️</span>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modern Tabs Navigation -->
    <div class="profile-tabs-nav">
        <button onclick="showSection('info-section')" class="tab-btn active" id="tab-info">Ver Información</button>
        <button onclick="showSection('edit-section')" class="tab-btn" id="tab-edit">Editar Perfil</button>
        <button onclick="showSection('password-section')" class="tab-btn" id="tab-password">Seguridad</button>
        <button onclick="showSection('deactivate-section')" class="tab-btn danger" id="tab-deactivate">Cuenta</button>
    </div>

    <!-- PHOTO UPDATE FORM (Now integrated and hidden by default) -->
    <div id="edit-foto-section" class="photo-update-box" style="display: none;">
        <div class="box-content">
            <h3>Actualizar Foto de Perfil</h3>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <div class="file-premium-input">
                    <label for="profile_photo_input" class="file-label">
                        <span class="upload-icon">📁</span>
                        <span id="file-name-display" class="upload-text">Haga clic para seleccionar foto...</span>
                    </label>
                    <input type="file" name="Usu_foto" id="profile_photo_input" required onchange="updateFileName(this)" style="display: none;">
                    <span class="file-hint">Formatos compatibles: JPG, PNG, GIF</span>
                </div>
                <div class="box-actions">
                    <button type="button" onclick="togglePhotoSection()" class="btn-cancel">Cancelar</button>
                    <button type="submit" class="btn-save">Subir Nueva Foto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTIONS CONTENT -->
    <div class="profile-sections-wrapper">
        
        <!-- INFO SECTION -->
        <div id="info-section" class="profile-section-content active">
            <div class="info-grid">
                <div class="info-item">
                    <label>Documento de Identidad</label>
                    <span class="value">{{ $user->Usu_documento }}</span>
                </div>
                <div class="info-item">
                    <label>Correo Electrónico</label>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <label>Teléfono de Contacto</label>
                    <span class="value">{{ $user->Usu_telefono ?? 'No registrado' }}</span>
                </div>
                <div class="info-item">
                    <label>Dirección de Residencia</label>
                    <span class="value">{{ $user->Usu_direccion ?? 'No registrada' }}</span>
                </div>
            </div>
        </div>

        <!-- EDIT SECTION -->
        <div id="edit-section" class="profile-section-content">
            <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="name" value="{{ $user->name }}" required placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" name="email" value="{{ $user->email }}" required placeholder="correo@ejemplo.com">
                    </div>
                    <div class="form-group">
                        <label>Teléfono / Celular</label>
                        <input type="text" name="Usu_telefono" value="{{ $user->Usu_telefono }}" placeholder="300 0000000">
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="Usu_direccion" value="{{ $user->Usu_direccion }}" placeholder="Calle 123 #45-67">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit-main">Guardar Cambios</button>
                </div>
            </form>
        </div>

        <!-- PASSWORD SECTION -->
        <div id="password-section" class="profile-section-content">
            <form action="{{ route('profile.password') }}" method="POST" class="profile-form mini">
                @csrf
                <div class="form-group">
                    <label>Contraseña Actual</label>
                    <input type="password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-actions center">
                    <button type="submit" class="btn-submit-password">Actualizar Contraseña</button>
                </div>
            </form>
        </div>

        <!-- DEACTIVATE SECTION -->
        <div id="deactivate-section" class="profile-section-content">
            <div class="danger-zone-box">
                <div class="danger-header">
                    <span class="icon">⚠️</span>
                    <h3>Zona de Peligro</h3>
                </div>
                <p>Al desactivar tu cuenta, no podrás acceder al sistema hasta que un administrador la reactive.</p>
                <form action="{{ route('profile.deactivate') }}" method="POST" onsubmit="return confirm('¿Estás SEGURO de que deseas desactivar tu cuenta?');">
                    @csrf
                    <button type="submit" class="btn-deactivate">Desactivar Mi Cuenta</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Modal para foto de perfil -->
<div id="modalFoto" class="modal-foto" onclick="cerrarModalFoto(event)">
    <div class="modal-foto-contenido" onclick="event.stopPropagation()">
        <img id="modalFotoImg" src="" alt="Foto de perfil ampliada">
        <button class="cerrar-modal-foto" onclick="cerrarModalFoto()">&times;</button>
    </div>
</div>

<style>
    /* Premium Profile Styles */
    .profile-premium-card {
        width: 100%;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.03);
        padding: 50px;
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }

    /* Back Button */
    .btn-back-professional {
        position: absolute;
        top: 25px;
        left: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
    }

    .btn-back-professional:hover {
        background: #f1f5f9;
        color: #1e293b;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Header Section */
    .profile-header-main {
        text-align: center;
        margin-bottom: 40px;
    }

    .avatar-container {
        position: relative;
        display: inline-block;
        padding: 8px;
        background: linear-gradient(135deg, #e2e8f0 0%, #ffffff 100%);
        border-radius: 50%;
        margin-bottom: 20px;
    }

    .main-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .main-avatar:hover {
        transform: scale(1.08);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .btn-edit-avatar {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: #2e8b57;
        color: white;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 10px rgba(46, 139, 87, 0.3);
        transition: all 0.3s ease;
        border: 3px solid white;
    }

    .btn-edit-avatar:hover {
        transform: scale(1.1);
        background: #246e45;
    }

    .profile-name {
        color: #1e293b;
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 10px 0;
        letter-spacing: -0.5px;
    }

    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        background: #f1f5f9;
        border-radius: 99px;
        gap: 8px;
    }

    .role-text {
        font-weight: 700;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .divider {
        width: 1px;
        height: 12px;
        background: #cbd5e1;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .status-dot.activo { background: #22c55e; }
    .status-dot.desactivo { background: #ef4444; }

    .status-text {
        font-weight: 600;
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Tabs Navigation */
    .profile-tabs-nav {
        display: flex;
        justify-content: center;
        gap: 12px;
        background: #f8fafc;
        padding: 8px;
        border-radius: 16px;
        margin-bottom: 40px;
    }

    .tab-btn {
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.25s ease;
        background: transparent;
        color: #64748b;
    }

    .tab-btn:hover {
        color: #1e293b;
        background: rgba(255,255,255,0.5);
    }

    .tab-btn.active {
        background: #ffffff;
        color: #2e8b57;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .tab-btn.danger.active {
        color: #ef4444;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        background: #fcfcfc;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
    }

    .info-item label {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .info-item .value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #334155;
    }

    /* Form Styles */
    .profile-form {
        padding: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 700;
        font-size: 0.9rem;
        color: #475569;
        margin-left: 4px;
    }

    .form-group input {
        padding: 14px 18px;
        border-radius: 14px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        font-size: 1rem;
        color: #1e293b;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-group input:focus {
        border-color: #2e8b57;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(46, 139, 87, 0.1);
    }

    .form-actions {
        margin-top: 35px;
        text-align: right;
    }

    .form-actions.center { text-align: center; }

    .btn-submit-main, .btn-submit-password {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 14px 35px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
    }

    .btn-submit-main:hover, .btn-submit-password:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(59, 130, 246, 0.3);
    }

    .btn-submit-password {
        background: #f59e0b; /* Ambar para seguridad */
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);
    }

    .btn-submit-password:hover {
        background: #d97706;
        box-shadow: 0 12px 24px rgba(245, 158, 11, 0.3);
    }

    /* Photo Update Box */
    .photo-update-box {
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .photo-update-box h3 {
        margin: 0 0 20px 0;
        color: #1e293b;
        font-size: 1.1rem;
        text-align: center;
    }

    .file-premium-input {
        text-align: center;
        margin-bottom: 25px;
    }

    .file-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 25px;
        background: #ffffff;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        max-width: 400px;
        margin: 0 auto;
    }

    .file-label:hover {
        border-color: #2e8b57;
        background: #f0fdf4;
        transform: translateY(-2px);
    }

    .upload-icon {
        font-size: 2rem;
    }

    .upload-text {
        font-weight: 600;
        color: #64748b;
        font-size: 0.9rem;
    }

    .file-hint {
        display: block;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 12px;
    }

    .box-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .btn-cancel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-save {
        background: #2e8b57;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    /* Alerts */
    .profile-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .profile-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .profile-alert.error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    .profile-alert ul { margin: 0; padding-left: 20px; }

    /* Danger Zone */
    .danger-zone-box {
        background: #fff1f2;
        border: 1px solid #fecaca;
        border-radius: 20px;
        padding: 35px;
        text-align: center;
    }

    .danger-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .danger-header h3 { color: #be123c; margin: 0; }

    .btn-deactivate {
        background: #e11d48;
        color: white;
        border: none;
        padding: 16px 40px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .btn-deactivate:hover {
        background: #be123c;
        transform: scale(1.02);
    }

    /* Section Visibility */
    .profile-section-content {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .profile-section-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-premium-card { padding: 30px 20px; }
        .info-grid, .form-grid { grid-template-columns: 1fr; }
        .tab-btn { padding: 10px 15px; font-size: 0.85rem; }
        .btn-back-professional { top: 15px; left: 15px; padding: 8px 12px; }
    }
</style>

<script>
    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.profile-section-content').forEach(el => el.classList.remove('active'));
        // Show target section
        document.getElementById(sectionId).classList.add('active');
        
        // Update tabs state
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        
        // Find which button was clicked (or find it by id if called directly)
        let btnId = 'tab-' + sectionId.split('-')[0];
        document.getElementById(btnId).classList.add('active');

        // Hide photo section when changing tabs (to keep it clean as requested)
        document.getElementById('edit-foto-section').style.display = 'none';
    }

    function togglePhotoSection() {
        const el = document.getElementById('edit-foto-section');
        const isHidden = el.style.display === 'none';
        
        if (isHidden) {
            // If we are showing the photo section, ensure we are on the EDIT tab for better UX
            showSection('edit-section');
            el.style.display = 'block';
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            el.style.display = 'none';
        }
    }
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "Seleccionar archivo...";
        document.getElementById('file-name-display').innerText = fileName;
        document.getElementById('file-name-display').style.color = "#1e293b";
    }

    // Funciones para modal de foto de perfil
    function abrirModalFoto(img) {
        const modal = document.getElementById('modalFoto');
        const modalImg = document.getElementById('modalFotoImg');
        if (modal && img) {
            modalImg.src = img.src;
            modal.classList.add('activo');
            document.body.style.overflow = 'hidden';
        }
    }

    function cerrarModalFoto(event) {
        const modal = document.getElementById('modalFoto');
        if (modal) {
            if (!event || event.target === modal || event.target.classList.contains('cerrar-modal-foto')) {
                modal.classList.remove('activo');
                document.body.style.overflow = 'auto';
            }
        }
    }

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarModalFoto();
        }
    });
</script>
