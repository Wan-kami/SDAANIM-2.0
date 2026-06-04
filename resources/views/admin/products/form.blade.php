@extends('layouts.app')

@section('content')
<main class="products-form-main">
    <section class="admin-form professional-form">
        <div class="form-header">
            <h1>{{ isset($product) ? '✏️ Editar Producto' : '➕ Nuevo Producto' }}</h1>
        </div>

        <form action="{{ isset($product) ? route('admin.products.update', $product->prod_id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
            @method('PUT')
            @endif

            @if($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Row 1: Nombre y Categoría -->
            <div class="form-row">
                <div class="form-group">
                    <label for="prod_nombre">📝 Nombre del Producto</label>
                    <p class="field-description">Nombre descriptivo del producto</p>
                    <input type="text" id="prod_nombre" name="prod_nombre" value="{{ isset($product) ? $product->prod_nombre : old('prod_nombre') }}" placeholder="Ej: Alimento Premium para Perros" required>
                </div>

                <div class="form-group">
                    <label for="prod_categoria">🏷️ Categoría</label>
                    <p class="field-description">Selecciona la categoría del producto</p>
                    <select id="prod_categoria" name="prod_categoria" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Alimentos" {{ (isset($product) && $product->prod_categoria == 'Alimentos') || old('prod_categoria') == 'Alimentos' ? 'selected' : '' }}>Alimentos</option>
                        <option value="Juguetes" {{ (isset($product) && $product->prod_categoria == 'Juguetes') || old('prod_categoria') == 'Juguetes' ? 'selected' : '' }}>Juguetes</option>
                        <option value="Camas" {{ (isset($product) && $product->prod_categoria == 'Camas') || old('prod_categoria') == 'Camas' ? 'selected' : '' }}>Camas</option>
                        <option value="Accesorios" {{ (isset($product) && $product->prod_categoria == 'Accesorios') || old('prod_categoria') == 'Accesorios' ? 'selected' : '' }}>Accesorios</option>
                        <option value="Ropa" {{ (isset($product) && $product->prod_categoria == 'Ropa') || old('prod_categoria') == 'Ropa' ? 'selected' : '' }}>Ropa</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Precio y Cantidad -->
            <div class="form-row">
                <div class="form-group">
                    <label for="prod_precio">💰 Precio</label>
                    <p class="field-description">Precio del producto en moneda local</p>
                    <div class="input-with-icon">
                        <span class="currency-icon">$</span>
                        <input type="number" step="0.01" id="prod_precio" name="prod_precio" value="{{ isset($product) ? $product->prod_precio : old('prod_precio') }}" placeholder="0.00" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="prod_cantidad">📦 Cantidad</label>
                    <p class="field-description">Stock disponible</p>
                    <input type="number" id="prod_cantidad" name="prod_cantidad" value="{{ isset($product) ? $product->prod_cantidad : old('prod_cantidad') }}" placeholder="0" required>
                </div>
            </div>

            <!-- Row 3: Descripción -->
            <div class="form-row full-width">
                <div class="form-group">
                    <label for="prod_descripcion">📄 Descripción</label>
                    <p class="field-description">Detalle completo del producto</p>
                    <textarea id="prod_descripcion" name="prod_descripcion" rows="4" placeholder="Describe el producto, características principales...">{{ isset($product) ? $product->prod_descripcion : old('prod_descripcion') }}</textarea>
                </div>
            </div>

            <!-- Row 4: Imagen -->
            <div class="form-row full-width">
                <div class="form-group">
                    <label for="prod_imagen">🖼️ Imagen del Producto</label>
                    <p class="field-description">Sube una imagen para el producto</p>
                    <label for="prod_imagen" class="file-input-wrapper">
                        <input type="file" id="prod_imagen" name="prod_imagen" accept="image/*">
                        <span class="file-input-label">Selecciona una imagen</span>
                    </label>

                    @if(isset($product) && $product->prod_imagen)
                    <div class="current-image">
                        <p><strong>Imagen actual:</strong></p>
                        <img src="{{ asset('img/' . $product->prod_imagen) }}" alt="{{ $product->prod_nombre }}" class="product-preview">
                    </div>
                    @endif
                </div>
            </div>

            @if(isset($product) && $product->hasVariants())
                <!-- SECCIÓN DE GESTIÓN DE COLORES (Solo para Ropa) -->
                @if($product->prod_categoria === 'Ropa')
                <div class="form-row full-width">
                    <div class="form-group">
                        <div class="section-header">
                            <h3>🎨 Gestión de Colores</h3>
                            <p class="section-description">Administra los colores disponibles para este producto</p>
                        </div>

                        <!-- Colores Existentes -->
                        @if($product->colors->count() > 0)
                        <div class="variants-list">
                            <h4>Colores Actuales:</h4>
                            <div class="variants-grid">
                                @foreach($product->colors as $color)
                                <div class="variant-card">
                                    <div class="variant-color-preview" style="background-color: {{ $color->color_hex }};" title="{{ $color->color_nombre }}"></div>
                                    <div class="variant-info">
                                        <span class="variant-name">{{ $color->color_nombre }}</span>
                                        <span class="variant-status {{ $color->disponible ? 'disponible' : 'no-disponible' }}">
                                            {{ $color->disponible ? '✓ Disponible' : '✗ No disponible' }}
                                        </span>
                                    </div>
                                    <div class="variant-actions">
                                        <form action="{{ route('admin.colors.delete', $color->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-delete-variant" onclick="return confirm('¿Eliminar este color?');">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Agregar Nuevo Color -->
                        <div class="add-variant-form">
                            <h4>Agregar Nuevo Color:</h4>
                            <form id="addColorForm" action="{{ route('admin.colors.add', $product->prod_id) }}" method="POST">
                                @csrf
                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="color_nombre">Nombre del Color</label>
                                        <input type="text" name="color_nombre" placeholder="Ej: Rojo Oscuro" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="color_hex">Código Hex</label>
                                        <input type="color" name="color_hex" value="#000000" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="disponible">Disponible</label>
                                        <select name="disponible" required>
                                            <option value="1" selected>Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn-add-variant" style="margin-top: 1rem;">+ Agregar Color</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- SECCIÓN DE GESTIÓN DE TALLAS (Solo para Ropa) -->
                @if($product->prod_categoria === 'Ropa')
                <div class="form-row full-width">
                    <div class="form-group">
                        <div class="section-header">
                            <h3>📏 Gestión de Tallas</h3>
                            <p class="section-description">Administra las tallas disponibles para este producto</p>
                        </div>

                        <!-- Tallas Existentes -->
                        @if($product->sizes->count() > 0)
                        <div class="variants-list">
                            <h4>Tallas Actuales:</h4>
                            <div class="variants-grid">
                                @foreach($product->sizes as $size)
                                <div class="variant-card">
                                    <div class="variant-size-badge">{{ $size->talla }}</div>
                                    <div class="variant-info">
                                        <span class="variant-name">{{ $size->talla }}</span>
                                        <span class="variant-quantity">Cantidad: {{ $size->cantidad }}</span>
                                        <span class="variant-status {{ $size->disponible ? 'disponible' : 'no-disponible' }}">
                                            {{ $size->disponible ? '✓ Disponible' : '✗ No disponible' }}
                                        </span>
                                    </div>
                                    <div class="variant-actions">
                                        <form action="{{ route('admin.sizes.delete', $size->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-delete-variant" onclick="return confirm('¿Eliminar esta talla?');">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Agregar Nueva Talla -->
                        <div class="add-variant-form">
                            <h4>Agregar Nueva Talla:</h4>
                            <form id="addSizeForm" action="{{ route('admin.sizes.add', $product->prod_id) }}" method="POST">
                                @csrf
                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="talla">Talla</label>
                                        <select name="talla" required>
                                            <option value="">Seleccionar</option>
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="number" name="cantidad" min="1" placeholder="0" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="disponible">Disponible</label>
                                        <select name="disponible" required>
                                            <option value="1" selected>Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0; display: flex; align-items: flex-end;">
                                        <button type="submit" class="btn-add-variant" style="width: 100%; margin-bottom: 0;">+ Agregar Talla</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endif

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    {{ isset($product) ? '✓ Actualizar Producto' : '✓ Crear Producto' }}
                </button>
                <a href="{{ route('admin.products') }}" class="btn-cancel">← Cancelar</a>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <strong>💡 Consejo:</strong> Asegúrate de completar todos los campos requeridos y de incluir una imagen clara del producto para mejorar la experiencia de los usuarios.
            </div>
        </form>
    </section>
</main>

<style>
    .products-form-main {
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
    .form-header {
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 1rem;
    }

    .form-header h1 {
        font-size: 1.8rem;
        color: #1a1a1a;
        margin: 0;
        font-weight: 700;
    }

    /* Professional Form Styles */
    .professional-form {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-row.full-width {
        grid-template-columns: 1fr;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.3rem;
        font-size: 1rem;
    }

    .field-description {
        font-size: 0.85rem;
        color: #888;
        margin: 0.2rem 0 0.8rem 0;
        font-style: italic;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        padding: 0.9rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background-color: #fafafa;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* Currency Input */
    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-icon {
        position: absolute;
        left: 12px;
        color: #4CAF50;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .input-with-icon input {
        padding-left: 2.5rem;
    }

    /* File Input */
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type="file"] {
        display: none;
    }

    .file-input-wrapper::before {
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

    .file-input-wrapper:hover::before {
        background: linear-gradient(135deg, #f0f0f0, #f5f5f5);
        border-color: #45a049;
    }

    .file-input-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #4CAF50;
        font-weight: 600;
        pointer-events: none;
    }

    /* Current Image */
    .current-image {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .current-image p {
        margin: 0 0 1rem 0;
        color: #333;
    }

    .product-preview {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
    }

    .btn-submit {
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

    .btn-submit:hover {
        background: linear-gradient(135deg, #45a049, #3d8b40);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(76, 175, 80, 0.3);
    }

    .btn-cancel {
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

    .btn-cancel:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    .form-errors {
        background: #ffe4e6;
        border: 1px solid #f8b4b4;
        color: #991b1b;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .form-errors ul {
        margin: 0;
        padding-left: 1.2rem;
    }

    .form-errors li {
        margin-bottom: 0.5rem;
    }

    .file-input-label {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 90%;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #fff8e1, #fffde7);
        border-left: 4px solid #fbc02d;
        padding: 1rem;
        border-radius: 8px;
        color: #d9a506;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Section Headers for Variants */
    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-header h3 {
        font-size: 1.3rem;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .section-description {
        margin: 0;
        color: #888;
        font-size: 0.9rem;
        font-style: italic;
    }

    /* Variants List */
    .variants-list {
        margin-bottom: 2rem;
    }

    .variants-list h4 {
        color: #333;
        font-size: 1rem;
        margin: 1rem 0 1rem 0;
        font-weight: 600;
    }

    .variants-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .variant-card {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .variant-card:hover {
        border-color: #4CAF50;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
    }

    .variant-color-preview {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        border: 2px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .variant-size-badge {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        border: 2px solid #4CAF50;
        background: #f0fdf4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #4CAF50;
        font-size: 1.2rem;
    }

    .variant-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.3rem;
        width: 100%;
        text-align: center;
    }

    .variant-name {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .variant-quantity {
        font-size: 0.8rem;
        color: #888;
    }

    .variant-status {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }

    .variant-status.disponible {
        background: #d4edda;
        color: #155724;
    }

    .variant-status.no-disponible {
        background: #f8d7da;
        color: #721c24;
    }

    .variant-actions {
        display: flex;
        gap: 0.5rem;
        width: 100%;
        justify-content: center;
    }

    .btn-delete-variant {
        padding: 0.5rem 1rem;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-delete-variant:hover {
        background: #fecaca;
        border-color: #f87171;
    }

    /* Add Variant Form */
    .add-variant-form {
        background: #f9fafb;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .add-variant-form h4 {
        color: #333;
        font-size: 1rem;
        margin: 0 0 1rem 0;
        font-weight: 600;
    }

    .btn-add-variant {
        padding: 0.9rem 1.5rem;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-add-variant:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(76, 175, 80, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-form-main {
            padding: 1rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-header h1 {
            font-size: 1.3rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .product-preview {
            width: 100%;
            height: 300px;
        }

        .variants-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .add-variant-form > div {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var fileInput = document.getElementById('prod_imagen');
        var labelText = document.querySelector('.file-input-label');

        if (fileInput && labelText) {
            fileInput.addEventListener('change', function () {
                if (fileInput.files.length) {
                    labelText.textContent = fileInput.files[0].name;
                } else {
                    labelText.textContent = 'Selecciona una imagen';
                }
            });
        }
    });
</script>

@endsection
