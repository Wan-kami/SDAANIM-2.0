@extends('layouts.app')

@section('content')

<div style="max-width: 900px; margin: 0 auto; padding: 2rem;">
    <div style="background: white; border-radius: 15px; padding: 3rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);">
        
        <h1 style="font-size: 2.2rem; color: #1a1a1a; margin: 0 0 2rem 0; font-weight: 700;">
            ➕ Agregar Nuevo Animal en Adopción
        </h1>

        @if($errors->any())
            <div style="background: #ffe4e6; border: 1px solid #f8b4b4; color: #991b1b; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                <strong>❌ Errores:</strong>
                <ul style="margin: 1rem 0 0 1.5rem; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li style="margin-bottom: 0.5rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Row 1: Nombre y Raza -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                        🐾 Nombre del Animal
                    </label>
                    <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                        Nombre descriptivo del animal
                    </p>
                    <input type="text" name="Anim_nombre" value="{{ old('Anim_nombre') }}" placeholder="Ej. Luna" required 
                        style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: all 0.3s ease;"
                        onblur="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#4CAF50'">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                        🏷️ Raza
                    </label>
                    <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                        Raza del animal
                    </p>
                    <input type="text" name="Anim_raza" value="{{ old('Anim_raza') }}" placeholder="Ej. Pitbull" required 
                        style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: all 0.3s ease;"
                        onblur="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#4CAF50'">
                </div>
            </div>

            <!-- Row 2: Edad y Sexo -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                        📅 Edad
                    </label>
                    <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                        Edad del animal
                    </p>
                    <input type="text" name="Anim_edad" value="{{ old('Anim_edad') }}" placeholder="Ej. 3 años" required 
                        style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: all 0.3s ease;"
                        onblur="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#4CAF50'">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                        ⚧️ Sexo
                    </label>
                    <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                        Selecciona el sexo
                    </p>
                    <select name="Anim_sexo" 
                        style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: all 0.3s ease;"
                        onblur="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#4CAF50'">
                        <option value="">Seleccionar sexo</option>
                        <option value="Macho" {{ old('Anim_sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ old('Anim_sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>
            </div>

            <!-- Row 3: Estado -->
            <div style="margin-bottom: 2.5rem;">
                <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                    ✓ Estado
                </label>
                <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                    Estado actual del animal
                </p>
                <select name="Anim_estado" required 
                    style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; transition: all 0.3s ease;"
                    onblur="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#4CAF50'">
                    <option value="">Seleccionar estado</option>
                    <option value="Disponible" {{ old('Anim_estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="Adoptado" {{ old('Anim_estado') == 'Adoptado' ? 'selected' : '' }}>Adoptado</option>
                    <option value="En proceso" {{ old('Anim_estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                </select>
            </div>

            <!-- Row 4: Historia -->
            <div style="margin-bottom: 2.5rem;">
                <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                    📄 Historia del Animal
                </label>
                <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                    Describe el historial y características del animal
                </p>
                <textarea name="Anim_historia" rows="6" placeholder="Describe la historia del animal, comportamiento, características especiales..." 
                    style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; font-family: inherit; transition: all 0.3s ease; resize: vertical;"
                    onblur="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#4CAF50'">{{ old('Anim_historia') }}</textarea>
            </div>

            <!-- Row 5: Foto -->
            <div style="margin-bottom: 2.5rem;">
                <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem; font-size: 1.1rem;">
                    🖼️ Fotografía del Animal
                </label>
                <p style="font-size: 0.9rem; color: #888; margin: 0 0 0.8rem 0; font-style: italic;">
                    Sube una foto clara del animal
                </p>
                <input type="file" id="Anim_foto" name="Anim_foto" accept="image/*" required 
                    style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; cursor: pointer;">
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1.5rem; margin-top: 3rem;">
                <button type="submit" 
                    style="flex: 1; padding: 1.2rem 2rem; background: linear-gradient(135deg, #4CAF50, #45a049); color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.background='linear-gradient(135deg, #45a049, #3d8b40)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(76, 175, 80, 0.3)';"
                    onmouseout="this.style.background='linear-gradient(135deg, #4CAF50, #45a049)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    ✓ Agregar Animal
                </button>
                <a href="{{ route('admin.animals') }}" 
                    style="flex: 1; padding: 1.2rem 2rem; background: #f0f0f0; color: #333; border: 2px solid #ddd; border-radius: 8px; font-size: 1.1rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.background='#e8e8e8'; this.style.borderColor='#ccc';"
                    onmouseout="this.style.background='#f0f0f0'; this.style.borderColor='#ddd';">
                    ← Cancelar
                </a>
            </div>

            <!-- Info Box -->
            <div style="background: linear-gradient(135deg, #fff8e1, #fffde7); border-left: 4px solid #fbc02d; padding: 1.5rem; border-radius: 8px; color: #d9a506; font-size: 1rem; line-height: 1.6; margin-top: 2rem;">
                <strong>💡 Consejo:</strong> Asegúrate de incluir una foto clara y una descripción detallada del animal para atraer más posibles adoptantes.
            </div>

        </form>
    </div>
</div>

@endsection
