@extends('layouts.app')

@section('content')
<main class="animals-form-main">
    <section class="admin-form professional-form-animals">
        <div class="form-header-animals">
            <h1>➕ Agregar Nuevo Animal en Adopción</h1>
        </div>

        <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Row 1: Nombre y Raza -->
            <div class="form-row-animals">
                <div class="form-group-animals">
                    <label for="Anim_nombre">🐾 Nombre del Animal</label>
                    <p class="field-description-animals">Nombre descriptivo del animal</p>
                    <input type="text" id="Anim_nombre" name="Anim_nombre" placeholder="Ej. Luna" required>
                </div>

                <div class="form-group-animals">
                    <label for="Anim_raza">🏷️ Raza</label>
                    <p class="field-description-animals">Raza del animal</p>
                    <input type="text" id="Anim_raza" name="Anim_raza" placeholder="Ej. Pitbull" required>
                </div>
            </div>

            <!-- Row 2: Edad y Sexo -->
            <div class="form-row-animals">
                <div class="form-group-animals">
                    <label for="Anim_edad">📅 Edad</label>
                    <p class="field-description-animals">Edad del animal</p>
                    <input type="text" id="Anim_edad" name="Anim_edad" placeholder="Ej. 3 años" required>
                </div>

                <div class="form-group-animals">
                    <label for="Anim_sexo">⚧️ Sexo</label>
                    <p class="field-description-animals">Selecciona el sexo</p>
                    <select id="Anim_sexo" name="Anim_sexo">
                        <option value="">Seleccionar sexo</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
            </div>

            <!-- Row 3: Estado -->
            <div class="form-row-animals full-width-animals">
                <div class="form-group-animals">
                    <label for="Anim_estado">✓ Estado</label>
                    <p class="field-description-animals">Estado actual del animal</p>
                    <select id="Anim_estado" name="Anim_estado" required>
                        <option value="">Seleccionar estado</option>
                        <option value="Disponible">Disponible</option>
                        <option value="Adoptado">Adoptado</option>
                        <option value="En proceso">En proceso</option>
                    </select>
                </div>
            </div>

            <!-- Row 4: Historia -->
            <div class="form-row-animals full-width-animals">
                <div class="form-group-animals">
                    <label for="Anim_historia">📄 Historia del Animal</label>
                    <p class="field-description-animals">Describe el historial y características del animal</p>
                    <textarea id="Anim_historia" name="Anim_historia" placeholder="Describe la historia del animal, comportamiento, características especiales..." rows="4"></textarea>
                </div>
            </div>

            <!-- Row 5: Foto -->
            <div class="form-row-animals full-width-animals">
                <div class="form-group-animals">
                    <label for="Anim_foto">🖼️ Fotografia del Animal</label>
                    <p class="field-description-animals">Sube una foto clara del animal</p>
                    <div class="file-input-wrapper-animals">
                        <input type="file" id="Anim_foto" name="Anim_foto" accept="image/*" required>
                        <span class="file-input-label-animals">Selecciona una imagen</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions-animals">
                <button type="submit" class="btn-submit-animals">
                    ✓ Agregar Animal
                </button>
                <a href="{{ route('admin.animals') }}" class="btn-cancel-animals">← Cancelar</a>
            </div>

            <!-- Info Box -->
            <div class="info-box-animals">
                <strong>💡 Consejo:</strong> Asegúrate de incluir una foto clara y una descripción detallada del animal para atraer más posibles adoptantes.
            </div>
        </form>
    </section>
</main>

<style>
    .animals-form-main {
        padding: 2rem;
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }

    .admin-form {
        width: 100%;
    }

    /* Form Header */
    .form-header-animals {
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 1rem;
    }

    .form-header-animals h1 {
        font-size: 1.8rem;
        color: #1a1a1a;
        margin: 0;
        font-weight: 700;
    }

    /* Professional Form Styles */
    .professional-form-animals {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }

    .form-row-animals {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-row-animals.full-width-animals {
        grid-template-columns: 1fr;
    }

    .form-group-animals {
        display: flex;
        flex-direction: column;
    }

    .form-group-animals label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.3rem;
        font-size: 1rem;
    }

    .field-description-animals {
        font-size: 0.85rem;
        color: #888;
        margin: 0.2rem 0 0.8rem 0;
        font-style: italic;
    }

    .form-group-animals input,
    .form-group-animals textarea,
    .form-group-animals select {
        padding: 0.9rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group-animals input:focus,
    .form-group-animals textarea:focus,
    .form-group-animals select:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background-color: #fafafa;
    }

    .form-group-animals textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* File Input */
    .file-input-wrapper-animals {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper-animals input[type="file"] {
        display: none;
    }

    .file-input-wrapper-animals::before {
        content: '';
        display: block;
        width: 100%;
        padding: 2rem;
        background: linear-gradient(135deg, #f5f5f5, #fafafa);
        border: 2px dashed #4CAF50;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .file-input-wrapper-animals:hover::before {
        background: linear-gradient(135deg, #f0f0f0, #f5f5f5);
        border-color: #45a049;
    }

    .file-input-label-animals {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #4CAF50;
        font-weight: 600;
        pointer-events: none;
    }

    /* Action Buttons */
    .form-actions-animals {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
    }

    .btn-submit-animals {
        flex: 1;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit-animals:hover {
        background: linear-gradient(135deg, #45a049, #3d8b40);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(76, 175, 80, 0.3);
    }

    .btn-cancel-animals {
        padding: 1rem 2rem;
        background: #f0f0f0;
        color: #333;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel-animals:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    /* Info Box */
    .info-box-animals {
        background: linear-gradient(135deg, #fff8e1, #fffde7);
        border-left: 4px solid #fbc02d;
        padding: 1rem;
        border-radius: 8px;
        color: #d9a506;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .animals-form-main {
            padding: 1rem;
        }

        .form-row-animals {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-header-animals h1 {
            font-size: 1.3rem;
        }

        .form-actions-animals {
            flex-direction: column;
        }
    }
</style>

@endsection
