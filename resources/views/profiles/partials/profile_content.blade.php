<div style="max-width: 900px; margin: 30px auto; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee; position: relative;">
    
    <a href="{{ route('dashboard') }}" class="premium-btn" style="position: absolute; top: 20px; left: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 5px;">
        ← Volver
    </a>

    <div style="text-align: center; margin-top: 20px;">
        <div style="position: relative; display: inline-block;">
            <img src="{{ $user->Usu_foto ? asset('img/profiles/' . $user->Usu_foto) . '?v=' . time() : asset('img/default-avatar.png') }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #2e8b57; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <button onclick="toggleSection('edit-foto-section')" style="position: absolute; bottom: 5px; right: 5px; background: #2e8b57; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">✏️</button>
        </div>
        <h2 style="color: #2c3e50; margin-top: 15px;">{{ $user->name }}</h2>
        <p style="color: #64748b; font-weight: bold; margin-bottom: 5px;">{{ $user->role }}</p>
        <div style="display: flex; justify-content: center; gap: 5px; align-items: center;">
            <span style="width: 10px; height: 10px; background: #22c55e; border-radius: 50%;"></span>
            <span style="color: #22c55e; font-weight: 600;">{{ $user->status }}</span>
        </div>
    </div>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; text-align: center;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- TABS BUTTONS -->
    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px;">
        <button onclick="showSection('info-section')" class="tab-btn active" style="padding: 10px 20px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; background: #1e293b; color: white;">Ver Información</button>
        <button onclick="showSection('edit-section')" class="tab-btn" style="padding: 10px 20px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; background: #f1f5f9; color: #475569;">Editar Perfil</button>
        <button onclick="showSection('password-section')" class="tab-btn" style="padding: 10px 20px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; background: #f1f5f9; color: #475569;">Cambiar Contraseña</button>
        <button onclick="showSection('deactivate-section')" class="tab-btn" style="padding: 10px 20px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; background: #fee2e2; color: #dc2626;">Desactivar Cuenta</button>
    </div>

    <!-- SECTIONS -->
    <div id="info-section" class="profile-section" style="display: block;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; padding: 25px; border-radius: 15px;">
            <div>
                <p style="color: #64748b; font-size: 0.9em; margin-bottom: 5px;">Documento</p>
                <p style="font-size: 1.1em; font-weight: 600; color: #1e293b; margin-top: 0;">{{ $user->Usu_documento }}</p>
            </div>
            <div>
                <p style="color: #64748b; font-size: 0.9em; margin-bottom: 5px;">Correo Electrónico</p>
                <p style="font-size: 1.1em; font-weight: 600; color: #1e293b; margin-top: 0;">{{ $user->email }}</p>
            </div>
            <div>
                <p style="color: #64748b; font-size: 0.9em; margin-bottom: 5px;">Teléfono</p>
                <p style="font-size: 1.1em; font-weight: 600; color: #1e293b; margin-top: 0;">{{ $user->Usu_telefono ?? 'No registrado' }}</p>
            </div>
            <div>
                <p style="color: #64748b; font-size: 0.9em; margin-bottom: 5px;">Dirección</p>
                <p style="font-size: 1.1em; font-weight: 600; color: #1e293b; margin-top: 0;">{{ $user->Usu_direccion ?? 'No registrada' }}</p>
            </div>
        </div>
    </div>

    <!-- PHOTO UPDATE FORM (Hidden initially) -->
    <div id="edit-foto-section" style="display: none; background: #f1f5f9; padding: 20px; border-radius: 15px; text-align: center; margin-bottom: 25px;">
        <h3 style="margin-top: 0; color: #1e293b;">Actualizar Foto de Perfil</h3>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
            @csrf
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="file" name="Usu_foto" required style="padding: 10px; border: 1px dashed #cbd5e1; border-radius: 8px; width: 100%; max-width: 300px; background: white;">
            <button type="submit" style="background: #2e8b57; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">Subir Foto</button>
        </form>
    </div>

    <!-- EDIT SECTION -->
    <div id="edit-section" class="profile-section" style="display: none;">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Nombre Completo</label>
                    <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Teléfono / Celular</label>
                    <input type="text" name="Usu_telefono" value="{{ $user->Usu_telefono }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Dirección</label>
                    <input type="text" name="Usu_direccion" value="{{ $user->Usu_direccion }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
            </div>
            <div style="margin-top: 25px; text-align: right;">
                <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer;">Guardar Cambios</button>
            </div>
        </form>
    </div>

    <!-- PASSWORD SECTION -->
    <div id="password-section" class="profile-section" style="display: none;">
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            <div style="max-width: 400px; margin: 0 auto;">
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Contraseña Actual</label>
                    <input type="password" name="current_password" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Nueva Contraseña</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: 600;">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
                </div>
                <div style="text-align: center;">
                    <button type="submit" style="background: #eab308; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%;">Actualizar Contraseña</button>
                </div>
            </div>
        </form>
    </div>

    <!-- DEACTIVATE SECTION -->
    <div id="deactivate-section" class="profile-section" style="display: none; text-align: center; padding: 30px; background: #fef2f2; border-radius: 15px; border: 1px solid #fecaca;">
        <h3 style="color: #dc2626; margin-top: 0;">⚠️ Zona de Peligro</h3>
        <p style="color: #7f1d1d; margin-bottom: 25px;">Si desactivas tu cuenta no podrás iniciar sesión hasta que sea reactivada.</p>
        <form action="{{ route('profile.deactivate') }}" method="POST" onsubmit="return confirm('¿Estás SEGURO de que deseas desactivar tu cuenta?');">
            @csrf
            <button type="submit" style="background: #dc2626; color: white; border: none; padding: 15px 30px; border-radius: 8px; font-weight: bold; cursor: pointer;">Desactivar Mi Cuenta</button>
        </form>
    </div>

</div>

<script>
    function showSection(sectionId) {
        document.querySelectorAll('.profile-section').forEach(el => el.style.display = 'none');
        document.getElementById(sectionId).style.display = 'block';
        
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.style.background = '#f1f5f9';
            btn.style.color = '#475569';
        });
        
        const activeBtn = event.currentTarget;
        if(sectionId === 'deactivate-section') {
            activeBtn.style.background = '#fee2e2';
            activeBtn.style.color = '#dc2626';
        } else {
            activeBtn.style.background = '#1e293b';
            activeBtn.style.color = 'white';
        }
    }

    function toggleSection(sectionId) {
        const el = document.getElementById(sectionId);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
</script>
